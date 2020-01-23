<?php
/** @package Openemr::Model::DAO */

/**
 *
 * Copyright (C) 2016-2017 Jerry Padgett <sjpadgett@gmail.com>
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEMR
 * @author Jerry Padgett <sjpadgett@gmail.com>
 * @link http://www.open-emr.org
 */

/** import supporting libraries */
require_once("verysimple/Phreeze/Phreezable.php");
require_once("PatientMap.php");

/**
 * PatientDAO provides object-oriented access to the patient_data table.  This
 * class is automatically generated by ClassBuilder.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the Model class which is extended from this DAO class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Openemr::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class PatientDAO extends Phreezable
{
    /** @var int */
    public $Id;

    /** @var string */
    public $Title;

    /** @var string */
    public $Language;

    /** @var string */
    public $Financial;

    /** @var string */
    public $Fname;

    /** @var string */
    public $Lname;

    /** @var string */
    public $Mname;

    /** @var date */
    public $Dob;

    /** @var string */
    public $Street;

    /** @var string */
    public $PostalCode;

    /** @var string */
    public $City;

    /** @var string */
    public $State;

    /** @var string */
    public $CountryCode;

    /** @var string */
    public $DriversLicense;

    /** @var string */
    public $Ss;

    /** @var longtext */
    public $Occupation;

    /** @var string */
    public $PhoneHome;

    /** @var string */
    public $PhoneBiz;

    /** @var string */
    public $PhoneContact;

    /** @var string */
    public $PhoneCell;

    /** @var int */
    public $PharmacyId;

    /** @var string */
    public $Status;

    /** @var string */
    public $ContactRelationship;

    /** @var string */
    public $EmergencyContact;

    /** @var date */
    public $ScheduleDate;

    /** @var string */
    public $Sex;

    /** @var string */
    public $Referrer;

    /** @var string */
    public $Referrerid;

    /** @var int */
    public $Providerid;

    /** @var int */
    public $RefProviderid;

    /** @var string */
    public $Email;

    /** @var string */
    public $EmailDirect;

    /** @var string */
    public $Ethnoracial;

    /** @var string */
    public $Race;

    /** @var string */
    public $Ethnicity;

    /** @var string */
    public $Religion;

    /** @var string */
    public $Interpretter;

    /** @var string */
    public $Migrantseasonal;

    /** @var string */
    public $FamilySize;

    /** @var string */
    public $MonthlyIncome;

    /** @var string */
    public $BillingNote;

    /** @var string */
    public $Homeless;

    /** @var date */
    public $FinancialReview;

    /** @var string */
    public $Pubpid;

    /** @var int */
    public $Pid;

    /** @var string */
    public $Genericname1;

    /** @var string */
    public $Genericval1;

    /** @var string */
    public $Genericname2;

    /** @var string */
    public $Genericval2;

    /** @var string */
    public $HipaaMail;

    /** @var string */
    public $HipaaVoice;

    /** @var string */
    public $HipaaNotice;

    /** @var string */
    public $HipaaMessage;

    /** @var string */
    public $HipaaAllowsms;

    /** @var string */
    public $HipaaAllowemail;

    /** @var string */
    public $Squad;

    /** @var int */
    public $Fitness;

    /** @var string */
    public $ReferralSource;

    /** @var string */
    public $Usertext1;

    /** @var string */
    public $Usertext2;

    /** @var string */
    public $Usertext3;

    /** @var string */
    public $Usertext4;

    /** @var string */
    public $Usertext5;

    /** @var string */
    public $Usertext6;

    /** @var string */
    public $Usertext7;

    /** @var string */
    public $Usertext8;

    /** @var string */
    public $Userlist1;

    /** @var string */
    public $Userlist2;

    /** @var string */
    public $Userlist3;

    /** @var string */
    public $Userlist4;

    /** @var string */
    public $Userlist5;

    /** @var string */
    public $Userlist6;

    /** @var string */
    public $Userlist7;

    /** @var string */
    public $Pricelevel;

    /** @var date */
    public $Regdate;

    /** @var date */
    public $Contrastart;

    /** @var string */
    public $CompletedAd;

    /** @var date */
    public $AdReviewed;

    /** @var string */
    public $Vfc;

    /** @var string */
    public $Mothersname;

    /** @var string */
    public $Guardiansname;

    /** @var string */
    public $AllowImmRegUse;

    /** @var string */
    public $AllowImmInfoShare;

    /** @var string */
    public $AllowHealthInfoEx;

    /** @var string */
    public $AllowPatientPortal;

    /** @var date */
    public $DeceasedDate;

    /** @var string */
    public $DeceasedReason;

    /** @var int */
    public $SoapImportStatus;

    /** @var string */
    public $CmsportalLogin;

    /** @var int */
    public $CareTeam;

    /** @var string */
    public $County;

    /** @var string */
    public $Industry;

    /** @var string */
    public $ChildName;

    /** @var int */
    public $ChildAge;

    /** @var string */
    public $PresentingProblem;

    /** @var string */
    public $HowCanWeHelpYou;

    /** @var int */
    public $AgreeTermsOfUse;
}
