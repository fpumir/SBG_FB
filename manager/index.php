<?php
$host = 'localhost';
$user = 'root';
$password = 'er8TuKmdJ24!Er';
$db = 'jeu_concours_sbg';

if(mysql_connect($host, $user, $password) && mysql_select_db($db)){

	$sql = 'SELECT * FROM players ORDER BY id ASC';

	    function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
        $result = mysql_query($query);

        if($headers) {
            // output header row (if at least one row exists)
            $row = mysql_fetch_assoc($result);

            $known = unserialize($row['known']);
            
            $row['known'] = '';
            
            foreach($known as $know){
            	$row['known'].= $know.', ';
            }

            $row['known'] = substr($row['known'], 0, -2);

            $quizz = unserialize($row['quizz']);
            unset($row['quizz']);

            $i = 1;

            foreach($quizz as $rep){
            	$question = 'Q'.$i;
            	$row[$question] = $rep;
            	$i++;
            }

            if($row) {
                fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = mysql_fetch_assoc($result)) {

            $known = unserialize($row['known']);
            
            $row['known'] = '';
            
            foreach($known as $know){
            	$row['known'].= $know.', ';
            }
							
						$row['known'] = substr($row['known'], 0, -2);

            $quizz = unserialize($row['quizz']);
            unset($row['quizz']);

            $i = 1;

            foreach($quizz as $rep){
            	$question = 'Q'.$i;
            	$row[$question] = $rep;
            	$i++;
            }

            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }

    $name_fichier = 'SBG-jeu-concours-fb-'.date('d-m-Y').'.csv';

    // output as an attachment
    query_to_csv($db_conn, $sql, $name_fichier, true);

}
else
{
	echo 'sql connection error'; die();
}


?>
