<?php
require_once 'vendor/autoload.php'; // Include PHPWord library (Install via Composer)

use PhpOffice\PhpWord\PhpWord;

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="application_details.docx"');

// Get form number from query parameter
$formNumber = isset($_GET['form_number']) ? intval($_GET['form_number']) : 0;

// Define form details
$formDetails = [
    1 => "Application for Passport Registration\nProvince: Western\nDistrict: Colombo\nDivisional Secretariat: Colombo City\nReason: First-time passport applicant",
    2 => "Mandatory Specifications\nFull Name (English): Awantha Perera\nFull Name (Sinhala/Tamil): අවන්තා පෙරේරා\nDate of Birth: 01/01/1990\nNIC Number: 199725678912\nGender: Male\nEmail Address: awantha@example.com\nType of Passport Required: Ordinary\nPurpose of Passport: Travel Abroad",
    3 => "Current Address\nHouse No.: 12A\nStreet/Area/Location: Galle Road\nCity/Village: Colombo\nPost Office: Colombo Central\nPin Code: 12345\nDistrict: Colombo",
    4 => "Payment Details\nPayment Method: Bank Transfer\nTransaction ID/Reference Number: SL1234567890\nPayment Amount (LKR): 5000",
    5 => "Optional Specialties\nEmail ID (optional): awantha.optional@example.com\nMobile No. (optional): +94 712345678",
    6 => "Supporting Documents\nYour Photo (Uploaded)\nAge Proof (Uploaded)\nAddress Proof (Uploaded)",
    7 => "Declaration\nI hereby declare that to the best of my knowledge and belief:\n(i) I am a citizen of Sri Lanka and my place of birth is:\nCity / Village: Colombo, Province: Western, District: Colombo.\n(ii) I am ordinarily resident at the address given above since Date: 01/01/2010.\n(iii) I have not applied for a Sri Lankan passport under any other name.\nI confirm that I have not previously applied for a Sri Lankan passport under any other name."
];

// Fetch the content for the selected form number
$content = isset($formDetails[$formNumber]) ? $formDetails[$formNumber] : "No details available for this form.";

// Create a new Word document
$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText($content);

// Save the Word file to output stream
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save("php://output");
