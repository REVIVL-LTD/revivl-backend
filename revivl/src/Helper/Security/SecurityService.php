<?php


namespace App\Helper\Security;


use App\Entity\Device;
use App\Entity\AbstractUser;
use App\Helper\Exception\ApiExceptionHandler;
use App\Helper\Status\DeviceStatus;
use App\Helper\Status\AbstractUserStatus;
use App\Service\AbstractService;
use App\Service\RequestValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityService extends AbstractService
{
    protected UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(EntityManagerInterface $entityManager,
                                ValidatorInterface $validator,
                                SerializerInterface $serializer,
                                RequestValidatorService $requestValidatorService,
                                UserPasswordEncoderInterface $encoder
    )
    {
        parent::__construct($entityManager, $validator, $serializer, $requestValidatorService);
        $this->userPasswordEncoder = $encoder;
    }

    public function logoutToken($token)
    {
        /** @var Device $device */
        $device = $this->em->getRepository(Device::class)->findOneBy(['token' => $token]);
        if (!$device)
            ApiExceptionHandler::errorApiHandlerMessage(null,
                                                        'Token not Found',
                                                        Response::HTTP_NOT_FOUND);
        $device->setStatus(DeviceStatus::ARCHIVE);
        $this->em->persist($device);
        $this->em->flush();
    }

    /**
     * @param $email
     * @param $password
     *
     * @return Device
     */
    public function login($email, $password): Device
    {
        /** @var AbstractUser $user */
        $user = $this->em->getRepository(AbstractUser::class)->findOneBy(['email' => $email, 'status' => AbstractUserStatus::ACTIVE]);
        if (!$user) {
            ApiExceptionHandler::errorApiHandlerMessage(
                'Not found',
                'User with this email not found',
                Response::HTTP_NOT_FOUND);
        }
        if (!$this->userPasswordEncoder->isPasswordValid($user, $password)) {
            ApiExceptionHandler::errorApiHandlerMessage(
                'Unauthorized',
                'Password Incorrect',
                Response::HTTP_UNAUTHORIZED);
        }

        $device = new Device();
        $device->setUser($user);
        $this->em->persist($device);
        $this->em->flush();
        return $device;
    }


    public static function checkIsApiRequestByUrlContain(Request $request): bool
    {
        $urlRoute = $request->getPathInfo();
        return str_contains($urlRoute, '/api/');
    }

    public static function checkIsApiRequestByHeaders(Request $request): bool
    {
        $acceptHeader = AcceptHeader::fromString($request->headers->get('Accept'));
        return $request->getContentType() === 'json' || $acceptHeader->has('application/json');
    }
}