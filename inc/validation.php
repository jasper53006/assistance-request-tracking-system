<?php
// Validate the request form before saving it to the database.
function validate_request($data) {
    $errors = array();
    $required_fields = array(
        'full_name' => 'Full name',
        'address' => 'Address',
        'barangay' => 'Barangay',
        'contact_number' => 'Contact number',
        'date_of_visit' => 'Date of visit',
        'purpose' => 'Purpose',
        'assistance_type' => 'Assistance type'
    );

    // Check all required fields.
    foreach ($required_fields as $field => $label) {
        if (trim($data[$field] ?? '') === '') {
            $errors[] = $label . ' is required.';
        }
    }

    // Make sure the selected type is one of the allowed categories.
    $allowed_types = array('Financial Assistance', 'Medical Assistance', 'Educational Assistance', 'Solicitation', 'Other');
    if (!empty($data['assistance_type']) && !in_array($data['assistance_type'], $allowed_types, true)) {
        $errors[] = 'Please select a valid assistance type.';
    }

    // Amounts must be numeric and cannot be negative.
    if (isset($data['amount_requested']) && (!is_numeric($data['amount_requested']) || $data['amount_requested'] < 0)) {
        $errors[] = 'Amount requested must be a non-negative number.';
    }

    return $errors;
}
?>
