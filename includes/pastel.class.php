<?php

/* * *
 * Name : pastel.class.php
 * Author: Lackson David <lacksinho@gmail.com>
 * Last Modified: Zalongwa Technologies Ltd <support@zalongwa.com>
 * */

class pastel {

    public function currentPayment($pastelurl, $regno, $view_type) {
		
		try {
			$ch = curl_init();

			if (FALSE === $ch)
				throw new Exception('failed to initialize');

			$nvp = "&regno=$regno&view_type=$view_type";
			curl_setopt($ch, CURLOPT_URL, $pastelurl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$content = curl_exec($ch);

			if(FALSE !== $content){
				return trim($content);
				}
			elseif (FALSE === $content){
				throw new Exception(curl_error($ch), curl_errno($ch));
				}
			} 
		catch(Exception $e) {
			trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
			}

        /*$ch = curl_init($pastelurl);
        $nvp = "regno=$regno";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        echo curl_exec($ch);*/
		}

    public function currentTransaction($pastelurl, $regno, $view_type) {
		
		try {
			$ch = curl_init();

			if (FALSE === $ch)
				throw new Exception('failed to initialize');

			$nvp = "&regno=$regno&view_type=$view_type";
			curl_setopt($ch, CURLOPT_URL, $pastelurl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$content = curl_exec($ch);

			if(FALSE !== $content){
				return trim($content);
				}
			elseif (FALSE === $content){
				throw new Exception(curl_error($ch), curl_errno($ch));
				}
			} 
		catch(Exception $e) {
			trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
			}

        /*$ch = curl_init($pastelurl);
        $nvp = "regno=$regno";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        echo curl_exec($ch);*/
		}

    public function resultCode($pastelurl, $regno, $view_type) {
        /*$ch = curl_init($pastelurl);
        $nvp = "regno=$regno";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        if (!$result) {
            echo "<br/><p><font color='#F00'> system error, try again later.</font><br/>";
            exit;
        } else {
            return trim($result);
        }*/
        
        try {
			$ch = curl_init();

			if (FALSE === $ch)
				throw new Exception('failed to initialize');
			
			$nvp = "&regno=$regno&view_type=$view_type";
			curl_setopt($ch, CURLOPT_URL, $pastelurl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$content = curl_exec($ch);
			
			if(FALSE !== $content){
				return trim($content);
				}
			elseif (FALSE === $content){
				throw new Exception(curl_error($ch), curl_errno($ch));
				}
			} 
		catch(Exception $e) {
			//trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
			echo "Curl failed with error #".$e->getCode()." ".$e->getMessage();
			}
		}
	}

?>
