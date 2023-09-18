<?php

function showContactTitle() {
    echo 'ProtoWebsite';
}

function showContactHeader() {
    echo 'Contacteer Mij';
}

function showContactContent() {
    require('validations.php');
    $inputdata = initializeFormData('contact');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputdata = validateContactForm($inputdata);
        if ($inputdata['valid']) {
            require('userservice.php');
            //display submitted inputdata if $valid is true
            showContactThanks($inputdata);
        } else {
            //display contact form if $valid is false
            showContactForm($inputdata);
        }
    } else {
        //display contact form by default if not a POST request
        showContactForm($inputdata);
    }
}

function showContactThanks($inputdata) {
    // Extract values from the $inputdata array
    extract($inputdata);

    echo '
    <h2>Beste ' . getSalutation($gender) . ' ' . $fname . ' ' . $lname . ', bedankt voor het invullen van uw gegevens!</h2>
    <h3>Ik zal zo snel mogelijk contact met u opnemen. Ter bevestiging uw informatie:</h3>
    <ul class="submitted_userdata">
        <li><strong>E-mailadres: </strong>' . $email . '</li>
        <li><strong>Telefoonnummer: </strong>' . $phone . '</li>
        <li><strong>Communicatievoorkeur: </strong>' . $preference . '</li>
        <li><strong>Bericht: </strong>' . $message . '</li>
    </ul>';
}

function showContactForm($inputdata) {
    // Extract values from the $inputdata array
    extract($inputdata);

    echo '
    <form method="post" action="index.php">
        <p><span class="error"><strong>* Vereist veld</strong></span></p>
        <ul class="flex-outer">

            <li>
                <label for="gender">Aanhef:</label>
                <select name="gender" id="gender">
                <option disabled selected value> -- maak een keuze -- </option>
                <option value="male" ' . ($gender == "male" ? "selected" : "") . '>Dhr.</option>
                <option value="female" ' . ($gender == "female" ? "selected" : "") . '>Mvr.</option>
                <option value="unspecified" ' . ($gender == "unspecified" ? "selected" : "") . '>Anders</option>
                </select>
                <span class="error">* ' . $genderErr . '</span>
            </li>

            <li>
                <label for="fname">Voornaam:</label>
                <input type="text" id="fname" name="fname" value="' . $fname . '">
                <span class="error">* ' . $fnameErr . '</span>
            </li>
            
            <li>
                <label for="lname">Achternaam:</label>
                <input type="text" id="lname" name="lname" value="' .$lname . '">
                <span class="error">* ' . $lnameErr . '</span>
            </li>
            
            <li>
                <label for="email">E-mailadres:</label>
                <input type="email" id="email" name="email" value="' . $email . '">
                <span class="error">* ' . $emailErr . '</span>
            </li>
            
            <li>
                <label for="phone">Telefoonnummer:</label>
                <input type="tel" id="phone" name="phone" value="' . $phone . '">
                <span class="error">* ' . $phoneErr . '</span>
            </li>
            
            <li>
                <legend>Communicatievoorkeur:</legend>
                <ul class="flex-inner">
                    <li>
                        <input type="radio" id="email" name="preference" value="email" ' . ($preference == "email" ? "checked" : "") . '>
                        <label for="email">Email</label>
                    </li>
                    <li>
                        <input type="radio" id="phone" name="preference" value="phone" ' . ($preference == "phone" ? "checked" : "") . '>
                        <label for="telefoon">Telefoon</label>
                    </li>
                </ul>
                <span class="error">* ' . $preferenceErr . '</span>
            </li>
            
            <li>
                <label for="bericht">Bericht:</label>
                <textarea id="message" name="message" rows="5" cols="33">' . $message . '</textarea>
                <span class="error">* ' . $messageErr . '</span>
            </li>
            
            <li>
                <button type="submit" name="page" value="contact">Verstuur</button>
            </li>
            
        </ul>
    </form>';
}

?>