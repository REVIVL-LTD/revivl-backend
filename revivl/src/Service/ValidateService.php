<?php

namespace App\Service;

use App\Helper\DTO\PaginationFilter;
use App\Helper\DTO\ResponseData;
use App\Helper\Exception\ApiException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateService
{
    public function __construct(private readonly ValidatorInterface $validator, private DenormalizerInterface $denormalizer)
    {
    }

    public function validRequest(Request $request, string $DtoName, array $groupsBody = [], array $groupsQueries= []): ResponseData
    {
        $body = $this->denormalizer->denormalize(
            json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR),
            $DtoName,
        );
        $queries = $this->denormalizer->denormalize(
            $request->query->all(),
            $DtoName,
        );
        $this->validate(body: $body, queries: $queries, groupsBody: $groupsBody, groupsQueries: $groupsQueries);

        return new ResponseData($body, $queries);
    }

    private function validate(object $body = null, object $queries = null, array $groupsBody = [], array $groupsQueries = []): void
    {
        $groupsBody [] = PaginationFilter::GROUP;
        $bodyError = $this->validator->validate($body, groups: $groupsBody);
        $validationError['body'] = self::getInvalidFields($bodyError);

        $groupsQueries [] = PaginationFilter::GROUP;
        $queriesError = $this->validator->validate($queries, groups: $groupsQueries);
        $validationError['query'] = self::getInvalidFields($queriesError);

        if (count($bodyError) > 0 || count($queriesError) > 0) {
            throw new ApiException(message: 'Bad Request', validationError: $validationError, statusCode: Response::HTTP_BAD_REQUEST);
        }
    }

    private static function getInvalidFields(ConstraintViolationListInterface $errors): array
    {
        $invalid_field = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $invalid_field[] = [
                'name' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }

        return $invalid_field;
    }

    public function passwordValid(string $password): void
    {
        $massage = match (true) {
            !$password => "This value should not be blank.",
            mb_strlen($password) < 8 => "Password too short! (min 8 symbols)",
            !preg_match("#[0-9]+#", $password) => "Password must include at least one number!",
            !preg_match("#[a-zA-Z]+#", $password) => "Password must include at least one letter!",
            !preg_match('~[\\\/:*?"\'<>|@]~', $password) => "Password must contain at least one special character!",
            default => null
        };

        if ($massage) {
            throw new ApiException(statusCode: Response::HTTP_BAD_REQUEST, message: $massage);
        }
    }

    public function validateEmail(string $email): void
    {
        if (!$email) {
            throw new ApiException(statusCode: Response::HTTP_BAD_REQUEST, message: 'This value should not be blank.');
        }

        $emailConstraint = new Email();
        $error = $this->validator->validate(
            $email,
            $emailConstraint
        );
        if (count($error) !== 0) {
            throw new ApiException(statusCode: Response::HTTP_BAD_REQUEST, message: 'This value is not a valid email address.');
        }
    }

    public static function validateInt($object, ExecutionContextInterface $context): void
    {
        if (!is_numeric($object) && $object !== '') {
            $context->buildViolation("This value should be of type int.")->addViolation();
        }
    }

    public static function validateBool($object, ExecutionContextInterface $context): void
    {
        if (!(is_bool($object) || $object === "0" || $object === "1" || $object === 0 || $object === 1 || $object === "true" || $object === "false"))
            $context->buildViolation($object . 'This value should be of type bool.')->addViolation();
    }

    public static function validateDateTime($object, ExecutionContextInterface $context): void
    {
        try {
            $date = new \DateTime($object);
        } catch (\Exception $e) {
            $context->buildViolation('ПThis value should be of type DateTime.')->addViolation();
        }
    }
}