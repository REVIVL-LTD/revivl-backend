<?php

namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Entity\Address;
use App\Entity\CodeAuth;
use App\Entity\Course;
use App\Entity\CourseUser;
use App\Entity\Order;
use App\Entity\Patient;
use App\Entity\Promocode;
use App\Helper\Status\OrderStatus;
use App\Helper\Status\UserStatus;
use App\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailApiController extends AbstractController
{
    //todo вынести все в сервис и mapped
    #[Route('/email/check', name: 'api_send_email_check', methods: "POST")]
    public function checkEmail(Request $request, MailService $mailService): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $email = $data['email'];
        $course = $data['course'];
        $name = $data['name'];
        $surname = $data['surname'];
        $birthday = $data['birthday'];
        $sex = $data['sex'];
        $phone = $data['phone'];
        $postcode = $data['postcode'];
        $city = $data['city'];
        $address = $data['address'];

        $user = $this->entityManager->getRepository(Patient::class)->checkEmail($email);
        $course = $this->entityManager->getRepository(Course::class)->find($course);
        if ($user) {
            return $this->json(["errors" => ["buy_email" =>"Email is not unique"]],Response::HTTP_CONFLICT );
        }

        $address = $this->entityManager->getRepository(Address::class)
            ->findOneBy(['postCode' => $postcode, 'city' => $city, 'addressLine' => $address]) ??
            (new Address())->setPostCode($postcode)->setCity($city)->setAddressLine($address);

        $promocode = $this->entityManager->getRepository(Promocode::class)->findOneBy(['name' => $data['promocode']]);

        $user = (new Patient())
            ->setStatus(UserStatus::NEW->value)
            ->setEmail($email)
            ->setName($name)
            ->setSurname($surname)
            ->setBirthday(new \DateTime($birthday))
            ->setSex($sex)
            ->setPhone($phone)
            ->setAddress($address)
            ->addPromocode($promocode)
        ;

        $courseUser = (new CourseUser())->setPatient($user)->setCourse($course);

        $this->entityManager->persist($address);
        $this->entityManager->persist($courseUser);
        $this->entityManager->persist($user);

        $mailService->checkEmail($user);

        $this->entityManager->flush();

        return $this->json(data: null, status: Response::HTTP_OK);
    }

    //ещвщ редирект на оплат  ????
    #[Route('/code/check', name: 'api_code_check', methods: "POST")]
    public function checkCodeEmail(Request $request): Response
    {
        $code = json_decode($request->getContent(), true)['code'];
        $email = json_decode($request->getContent(), true)['email'];

        if($code = $this->entityManager->getRepository(CodeAuth::class)->check($code, $email)) {

            $code->getPatient()->setStatus(UserStatus::WITHOUT_PASSWORD->value);
            $order = new Order($code->getPatient());
            //todo удалить после добавления оплаты
            $order->setStatus(OrderStatus::SUCCESS->value);
            $this->entityManager->persist($order);

            $this->entityManager->flush();

            $paymentId = $order->id;
            //todo нормальный адрес
//            $url = "/payment/check?$paymentId";
            $url = $paymentId;
            return $this->json(data: ['url' => $url], status: Response::HTTP_OK);
        }
        return $this->json(data: ["errors" => ["code" =>"Incorrect code"]], status: Response::HTTP_CONFLICT);
    }
}