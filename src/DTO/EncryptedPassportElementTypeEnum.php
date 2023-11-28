<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum EncryptedPassportElementTypeEnum: string
{
    case PersonalDetails = 'personal_details';
    case Passport = 'passport';
    case DriverLicense = 'driver_license';
    case IdentityCard = 'identity_card';
    case InternalPassport = 'internal_passport';
    case Address = 'address';
    case UtilityBill = 'utility_bill';
    case BankStatement = 'bank_statement';
    case RentalAgreement = 'rental_agreement';
    case PassportRegistration = 'passport_registration';
    case TemporaryRegistration = 'temporary_registration';
    case PhoneNumber = 'phone_number';
    case Email = 'email';
}
