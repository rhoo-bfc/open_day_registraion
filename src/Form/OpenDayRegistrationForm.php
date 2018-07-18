<?php
/**
 * @file
 * Contains \Drupal\open_day_registration\Form\PageExampleForm
 */
namespace Drupal\open_day_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class OpenDayRegistrationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'open_day_registration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['introduction'] = [
      '#type' => 'html_tag',
      '#value' => $this->t('B&FC Open Day: Registration Form'),
      '#tag' => 'h3',
      '#weight' => -10
    ];

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    $form['surname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Surname'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    $date_format = 'd/m/Y';

    $form['dob'] = [
      '#type' => 'datelist',
      '#title' => $this->t('Date of Birth'),
      '#date_part_order' => array('day', 'month', 'year'),
      '#date_year_range' => '1940:2010',
      '#date_date_format' => $date_format,
      '#required' => TRUE,
      '#readonly' => TRUE
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#maxlength' => 255,
      '#required' => TRUE
    ];

    $form['confirm_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Confirm Email'),
      '#maxlength' => 255,
      '#required' => TRUE
    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#maxlength' => 15,
      '#required' => TRUE
    ];

    $form['school_name'] = [
      '#type' => 'select',
      '#title' => $this->t('Which school have you attended in the past 3 years?'),
      '#required' => TRUE,
      '#options' => [
        '1' => $this->t('Elective Home Education/School'),
        '2' => $this->t('AKS (formally Arnold KEQMS)'),
        '3' => $this->t('Aspire Academy (formally Bispham High School & Collegiate school)'),
        '4' => $this->t('Baines School'),
        '5' => $this->t('Blacpool Sixth Form'),
        '6' => $this->t('Blackpool Woodlands School'),
        '7' => $this->t('Cardinal Allen Catholic High School'),
        '8' => $this->t('Carr Hill High School'),
        '9' => $this->t('Educational Diversity'),
        '10' => $this->t('Fleetwood High School'),
        '11' => $this->t('Great Arley School'),
        '12' => $this->t('Highfield Leadership Academy'),
        '13' => $this->t('Hodgson Academy'),
        '14' => $this->t('Kirkham Grammar School'),
        '15' => $this->t('Lytham St Annes High School'),
        '16' => $this->t('McKee Centre'),
        '17' => $this->t('Millfield Science and Performing Arts College'),
        '18' => $this->t('Montgomery High School'),
        '19' => $this->t('Park Community Academy'),
        '20' => $this->t('Red Marsh School'),
        '21' => $this->t('Saint Aidan’s Church of England High School'),
        '22' => $this->t('South Shore Academy (formally Palatine Community Sports College)'),
        '23' => $this->t('St Bedes Catholic High School'),
        '24' => $this->t('St Georges School'),
        '25' => $this->t('St Marys Catholic College'),
        '26' => $this->t('Unity Academy (formally Beacon Hill High School)'),
        '27' => $this->t('Other'),
      ]
    ];

    $form['address'] = [
      '#type' => 'html_tag',
      '#tag' => 'h4',
      '#value' => $this->t('Address')
    ];

    $form['house'] = [
      '#type' => 'textfield',
      '#title' => $this->t('House Name/Number'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    $form['street'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Street Address'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Town/City'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    $form['postcode'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postcode'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];

    // $form['golden_ticket'] = [
    //   '#type' => 'checkbox',
    //   '#title' => $this->t('Tick this box if you have a Golden ticket and would like to enter into our prize draw.')
    // ];

    $form['subscribe'] = [
      '#type' => 'checkbox',
      '#title' => $this->t(' Tick this box to receive information about our events, news and courses.')
    ];

    //always place the submission button at the end of the form with the heaviest weight (10)
    $form['show'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#weight' => 10
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // retrieve values from form state object
    $first_name = $form_state->getValue('first_name');
    $surname = $form_state->getValue('surname');
    $email = $form_state->getValue('email');
    $confirm_email = $form_state->getValue('confirm_email');
    $phone_number = $form_state->getValue('phone_number');

    if (strlen(trim($first_name)) > 0 && !preg_match('/^[a-z A-Z\'\-]+$/', $first_name)) {
      $form_state->setErrorByName('first_name', $this->t('Name contains invalid characters. Only letters are allowed!'));
    }

     if (strlen(trim($surname)) > 0 && !preg_match('/^[a-z A-Z\'\-]+$/', $surname)) {
      $form_state->setErrorByName('surname', $this->t('Name contains invalid characters. Only letters are allowed!'));
    }

    // check emails address are in valid format and match
    if(!valid_email_address($email)){
      $form_state->setErrorByName('email', $this->t('Sorry the email address you entered is not valid'));
    }

    if(!valid_email_address($confirm_email)){
      $form_state->setErrorByName('confirm_email', $this->t('Sorry the email address you entered is not valid'));
    }

    if(strcmp($email,$confirm_email) != 0){
      $form_state->setErrorByName('confirm_email', $this->t('Sorry the email addresses you entered do not match'));
    }

    if (strlen($phone_number) > 0) {
      $chars = array(' ','-','(',')','[',']','{','}');
      $phone_number = str_replace($chars,'',$phone_number);

      if (preg_match('/^(\+)[\s]*(.*)$/',$phone_number)){
        $form_state->setErrorByName('phone_number', $this->t('UK telephone number without the country code, please'));
      }

      if (!preg_match('/^[0-9]{10,11}$/',$phone_number)) {
        $form_state->setErrorByName('phone_number', $this->t('UK telephone numbers should contain 10 or 11 digits'));
      }

      if (!preg_match('/^0[0-9]{9,10}$/',$phone_number)) {
        $form_state->setErrorByName('phone_number', $this->t('The telephone number should start with a 0'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $form_values = $form_state->getValues();

    //log submission in watchdog
    $message = "Open Day RegistrationSubmitted";

    foreach($form_state->getValues() as $value){
      $message = $message . ' ' . $value;
    }

    \Drupal::logger('open_day_registration')->info($message);

    // transform required values
    $address = array(
      'country_code' => 'GB',
      'address_line1' => $form_values['house'] . ' ' . $form_values['street'],
      'locality' => $form_values['city'],
      'postal_code' => strtoupper($form_values['postcode']),
    );

    // create graduation booking node
    $new_open_day_registration_values = array(
      // set basic node data
      'nid' => NULL,
      'type' => 'open_day_registration',
      'uid' => 1,
      'status' => TRUE,
      'promote' => 0,
      'created' => time(),

      // set title
      'title' => ucwords(strtolower($form_values['first_name'])),

      // set code fields
      'field_surname' => $form_values['surname'],
      'field_home_address' => $address,
      'field_date_of_birth' => $form_values['dob']->format('Y-m-d'),
      'field_email_address' => $form_values['email'],
      'field_high_school' => $form_values['school_name'],
      'field_telephone_number' => $form_values['phone_number'],
      // 'field_golden_ticket_draw' => $form_values['golden_ticket'],
      'field_subscribe' => $form_values['subscribe']
    );

    $new_open_day_registration = entity_create('node', $new_open_day_registration_values);

    $new_open_day_registration->save();

    // set path alias to UI Code
    $path = array(
      'source' => '/node/' . $new_open_day_registration->id(),
      'alias' => '/open_day_registration/' . $new_open_day_registration->id(),
    );

    \Drupal::service('path.alias_storage')->save($path['source'], $path['alias']);

    drupal_set_message($this->t('Thank you for registering'));
  }
}
