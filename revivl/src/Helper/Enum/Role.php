<?php

enum Role: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_PATIENT = 'ROLE_PATIENT';
    case ROLE_DOCTOR = 'ROLE_DOCTOR';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}