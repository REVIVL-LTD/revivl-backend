<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\CodeAuth;
use App\Entity\Course;
use App\Entity\CourseUser;
use App\Entity\Order;
use App\Entity\Patient;
use App\Entity\Promocode;
use App\Helper\DTO\EmailAuthDto;
use App\Helper\Exception\ApiException;
use App\Helper\Status\OrderStatus;
use App\Helper\Status\UserStatus;
use Symfony\Component\HttpFoundation\Response;

class AutorizationService extends AbstractService
{
    public function chechCode(int $code, string $email)
    {
        if($codeAuth = $this->entityManager->getRepository(CodeAuth::class)->check($code, $email)) {

            $codeAuth->getPatient()->setStatus(UserStatus::WITHOUT_PASSWORD->value);
            $order = new Order($codeAuth->getPatient());
            //todo удалить после добавления оплаты
            $order->setStatus(OrderStatus::SUCCESS->value);
            $this->entityManager->persist($order);

            $this->entityManager->flush();

            $paymentId = $order->id;
            //todo нормальный адрес
//            $url = "/payment/check?$paymentId";
            $url = $paymentId;
            return  $url;
        }
        throw new ApiException(statusCode: Response::HTTP_CONFLICT, castom: ["code" =>"Incorrect code"]);
    }


    public function checkEmail(EmailAuthDto $body)
    {
        $user = $this->entityManager->getRepository(Patient::class)->checkEmail($body->email);
        $course = $this->entityManager->getRepository(Course::class)->find($body->course);
        if ($user) {
            throw new ApiException(statusCode: Response::HTTP_CONFLICT, castom: ["buy_email" =>"Email is not unique"]);
        }

        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['postCode' => $body->postCode, 'city' => $body->city, 'addressLine' => $body->address]) ??
            (new Address())->setPostCode($body->postCode)->setCity($body->city)->setAddressLine($body->address);

        $promocode = $this->entityManager->getRepository(Promocode::class)->findOneBy(['name' => $body->promocode]);

        $user = (new Patient())
            ->setStatus(UserStatus::NEW->value)
            ->setEmail($body->email)
            ->setName($body->name)
            ->setSurname($body->surname)
            ->setBirthday($body->getBirthday())
            ->setSex($body->getSex())
            ->setPhone($body->phone)
            ->setAddress($address)
            ->addPromocode($promocode)
        ;

        $courseUser = (new CourseUser())->setPatient($user)->setCourse($course);

        $this->entityManager->persist($address);
        $this->entityManager->persist($courseUser);
        $this->entityManager->persist($user);

        $this->mailService->checkEmail($user);

        $this->entityManager->flush();
    }
}