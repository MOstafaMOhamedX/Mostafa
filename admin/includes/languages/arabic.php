<?php

  function lang ( $phrase ){
    static $lang = array(

      'MESSAGE' => 'اهلا '

    );
    return $lang[$phrase];
  }
