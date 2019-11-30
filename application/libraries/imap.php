<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /* Library Class: Imap */

    class Imap {


        // Open IMAP connection

        function cimap_open($host, $mailbox, $username, $password)
        {
            return imap_open('{'.$host.':993/imap/ssl/novalidate-cert}'.$mailbox, $username, $password);
        }

        // Find number of msg in mailbox

        function cimap_num_msg($imap_connection)
        {
            return imap_num_msg($imap_connection);
        }

        // Find disk quota amount

        function cimap_get_quota($imap_connection)
        {
            $storage = $quota['STORAGE']= imap_get_quotaroot($imap_connection, "INBOX");

            function kilobyte($filesize)
            {
                return round($filesize / 1024, 2) . ' Mb';
            }

            return kilobyte($storage['usage']) . ' / ' . kilobyte($storage['limit']) . ' (' . round($storage['usage'] / $storage['limit'] * 100, 2) . '%)';
        }  
        function cimap_get_email($imap_connection)
        {
            $get_message = imap_get_quotaroot($imap_connection, "INBOX");

        }    
        function get_informatom_mailbox($imap_connection){
            return imap_check ($imap_connection);
        }
        function get_sorted_mail($imap_connection){
            return imap_sort ( $imap_connection , SORTDATE ,1 );
        }
         function get_mail_header($imap_connection){
            return imap_headers ( $imap_connection);
        }
        function get_overview($imap_connection){
            $source = $this->get_informatom_mailbox($imap_connection);
            return imap_fetch_overview($imap_connection,"1:{$source->Nmsgs}",0);
        }
    }

?>