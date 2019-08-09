<!--

function isCookieAllowed(){
   setCookie('cookie_allowed',1,10); 
   if(readCookie('cookie_allowed') != 1) {alert(DGVocabulary._MSG["cookies_required"]); return false; }; 
   return true; 
}

function setCookie(name,value,days) {
   if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = '; expires='+date.toGMTString();
   }
   else var expires = '';
   document.cookie = name+'='+value+expires+'; path=/';
}

function readCookie(name) {
   var nameEQ = name + '=';
   var ca = document.cookie.split(';');
   for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
   }
   return null;
}

// load new event 
function addDgLoadEvent(func) {
   var oldonload = window.onload;
   if (typeof window.onload != 'function') {
      window.onload = func;
   }else {
      window.onload = function() {
      oldonload();
      func();
      }
   }
}

// hide/unhide Filtering
function hideUnHideFiltering(type, unique_prefix){
   if(!isCookieAllowed()) return false;
   unique_prefix = (unique_prefix == null) ? '' : unique_prefix;
   if(type == 'hide'){
      document.getElementById(unique_prefix+'searchset').style.display = 'none'; 
      document.getElementById(unique_prefix+'a_hide').style.display = 'none'; 
      document.getElementById(unique_prefix+'a_unhide').style.display = ''; 
      setCookie(unique_prefix+'hide_search',1,1); 
   }else{
      document.getElementById(unique_prefix+'searchset').style.display = ''; 
      document.getElementById(unique_prefix+'a_hide').style.display = ''; 
      document.getElementById(unique_prefix+'a_unhide').style.display = 'none'; 
      setCookie(unique_prefix+'hide_search',0,1); 
   }
   return true;
}

// reload form with some action, saving entered data
function formAction(file_act, file_id, unique_prefix, http_url, query_string){
   unique_prefix = (unique_prefix==null) ? "" : unique_prefix;
   http_url = (http_url==null) ? "" : http_url;
   query_string = (query_string==null) ? "" : query_string;
   //alert(http_url+"?"+query_string+"&"+unique_prefix+"file_act="+file_act+"&"+unique_prefix+"file_id="+file_id);	   

   document.getElementById(unique_prefix+'frmEditRow').action=http_url+"?"+query_string+"&"+unique_prefix+"file_act="+file_act+"&"+unique_prefix+"file_id="+file_id;
   document.getElementById(unique_prefix+'frmEditRow').encoding='multipart/form-data';
   document.getElementById(unique_prefix+'frmEditRow').method='POST';
   document.getElementById(unique_prefix+'frmEditRow').submit();
}

// calendar script (popup)
function openCalendar(directory, params, form, req_type, field, type) {
   if (type != 'time') height = '240'; else height = '100';
   window.open(directory+'modules/calendar/calendar.php?' + params, 'calendar', 'width=220, height='+height+',status=yes');
   if (req_type.length > 0){
      dateField = eval('document.' + form + '.' + req_type);
   }else{
      dateField = eval('document.' + form + '.' + field);
   }
   dateType = type;
}

// setCalendar datetime for ddl's
function setCalendarDate(frm, date_field, datetime_format, date_value, year_start, is_default)
{
   year    = (document.getElementById(date_field+'__nc_year')   != null) ? document.getElementById(date_field+'__nc_year').value : '0000';
   month   = (document.getElementById(date_field+'__nc_month')  != null) ? document.getElementById(date_field+'__nc_month').value : '00';
   day     = (document.getElementById(date_field+'__nc_day')    != null) ? document.getElementById(date_field+'__nc_day').value : '00';
   hour    = (document.getElementById(date_field+'__nc_hour')   != null) ? document.getElementById(date_field+'__nc_hour').value : '00';
   minute  = (document.getElementById(date_field+'__nc_minute') != null) ? document.getElementById(date_field+'__nc_minute').value : '00';
   second  = (document.getElementById(date_field+'__nc_second') != null) ? document.getElementById(date_field+'__nc_second').value : '00';
   date_value = (date_value != null) ? date_value : '';
   year_start = (year_start != null) ? year_start : '0';
   is_default = (is_default != null) ? is_default : true;

   if(date_value != ''){
      // Set date if datetime link was clicked / or by default
      document.getElementById(date_field).value = date_value;
      year    = date_value.substring(0,4);
      month   = date_value.substring(5,7);
      day     = date_value.substring(8,10);
      hour     = date_value.substring(11,13);
      minute   = date_value.substring(14,16);
      second   = date_value.substring(17,19);

      if(datetime_format.match('d-m-Y') && !is_default){
         day    = date_value.substring(0,2);
         month  = date_value.substring(3,5);
         year   = date_value.substring(6,10);
         ///alert("d-m-Y");
      }else if(datetime_format.match('m-d-Y') && !is_default){
         day    = date_value.substring(3,5);
         month  = date_value.substring(0,2);
         year   = date_value.substring(6,10);         
         ///alert("m-d-Y "+ date_value);
      }

      if((datetime_format == 'Y-m-d') || (datetime_format == 'd-m-Y')){
         document.getElementById(date_field+'__nc_year').selectedIndex = year-year_start+1;
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         ///alert("b");
      }else if((datetime_format == 'Y-m-d H:i:s') || (datetime_format == 'd-m-Y H:i:s') || (datetime_format == 'd-m-Y H:i') || (datetime_format == 'Y-m-d H:i')){         
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         document.getElementById(date_field+'__nc_hour').selectedIndex = parseInt(hour) + parseInt('1');
         document.getElementById(date_field+'__nc_minute').selectedIndex = parseInt(minute) + parseInt('1');
         if(datetime_format != 'd-m-Y H:i' && datetime_format != 'Y-m-d H:i') document.getElementById(date_field+'__nc_second').selectedIndex = parseInt(second) + parseInt('1');
         ///alert("c");
      }else if(datetime_format == 'm-d-Y'){
         ///alert("m-d-Y "+ month+' '+day+' '+year);
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
      }else{
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         ///alert("e");
      }
   }else{      
      // Set date if ddl was changed                    
      if(datetime_format == 'Y-m-d'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day;
      }else if(datetime_format == 'd-m-Y'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year;
      }else if(datetime_format == 'Y-m-d H:i:s'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
      }else if(datetime_format == 'Y-m-d H:i'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day+' '+hour+':'+minute;
      }else if(datetime_format == 'd-m-Y H:i:s'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year+' '+hour+':'+minute+':'+second;
      }else if(datetime_format == 'd-m-Y H:i'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year+' '+hour+':'+minute;
      }else{
         document.getElementById(date_field).value = year+'-'+month+'-'+day;
      }
   }
   // Clear date field if was entered date empty
   if((document.getElementById(date_field).value.length != 10) && (document.getElementById(date_field).value.length != 19) && (document.getElementById(date_field).value.length != 16)){
       document.getElementById(date_field).value = '';
   }
}

// generate password
function getRandomNum(lbound, ubound) {
    return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
}
function getRandomChar(number, lower, upper, other, extra) {
   var numberChars = "0123456789";
   var lowerChars = "abcdefghijklmnopqrstuvwxyz";
   var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   var otherChars = "`~!@#$%^&*()-_=+[{]}\\|;:'\",<.>/? ";
   var charSet = extra;
   if (number == true) charSet += numberChars;
   if (lower == true) charSet += lowerChars;
   if (upper == true) charSet += upperChars;
   if (other == true) charSet += otherChars;
   return charSet.charAt(getRandomNum(0, charSet.length));
}
function generatePassword(length) {
   extraChars = "";
   firstNumber = true; firstLower = true; firstUpper = true; firstOther = false;
   latterNumber = true; latterLower = true; latterUpper = true; latterOther = false;
   var rc = "";
   if (length > 0) rc = rc + getRandomChar(firstNumber, firstLower, firstUpper, firstOther, extraChars);
   for (var idx = 1; idx < length; ++idx) {
      rc = rc + getRandomChar(latterNumber, latterLower, latterUpper, latterOther, extraChars);
   }
   return rc;
}

// reset dropdown box
function resetDDL(el){
   if(document.getElementById(el)) document.getElementById(el).selectedIndex = 0;
}

// send edit mode fields
function jsSendEditFields(uniquePrefix, browserName, jsValidationErrors){
   var result_value = true;
   var on_submit_my_check = true;
   if(window[uniquePrefix+"onSubmitMyCheck"]){ if(!window[uniquePrefix+"onSubmitMyCheck"]()){ on_submit_my_check = false; } };
   // two different parts of code to find & save wysiwyg editor data
   
   if(browserName == "Firefox"){
       result_value = window["updateWysiwygFieldsFF"](uniquePrefix);
   }else{ // "MSIE" or other
      result_value = window["updateWysiwygFieldsIE"](uniquePrefix);
   };
   var frmEditRow = document.getElementById(uniquePrefix+"frmEditRow");
   if(result_value == true && on_submit_my_check == true && onSubmitCheck(frmEditRow, jsValidationErrors)){
       frmEditRow.submit();
   }else{
       false;
   }
}

function updateWysiwygFieldsIE(uniquePrefix, perform_check){
    var result_value_ie = true;
    var perform_check = (perform_check != null) ? perform_check : true;
    var frmEditRow = document.getElementById(uniquePrefix+"frmEditRow");

    for (var idx=0; idx < frmEditRow.length; idx++) {
        field_name = frmEditRow.elements.item(idx).name;                    
        field_type = frmEditRow.elements.item(idx).type;
        
        // check file or image fields
        if(field_type == 'file' && perform_check){
            if(document.getElementById(field_name).value != ''){
               alert(DGVocabulary._MSG["need_upload_file"]);
               result_value_ie = false;
            }
        }
        field_full_name = 'wysiwyg' + field_name;                    
        if(document.getElementById(field_full_name)){
            document.getElementById(field_name).value = document.getElementById(field_full_name).contentWindow.document.body.innerHTML;                        
            if((document.getElementById(field_name).value == '<br>') || (document.getElementById(field_name).value == '<P>&nbsp;</P>') || (document.getElementById(field_name).value == '&lt;P&gt;&nbsp;&lt;/P&gt;')){
                document.getElementById(field_name).value = '';
            }
        }
    }
    return result_value_ie;
}

function updateWysiwygFieldsFF(uniquePrefix, perform_check){
    var result_value_ff = true;
    var perform_check = (perform_check != null) ? perform_check : true;
    elements = document.getElementsByTagName('*');
    for (var idx = 0; idx < elements.length; idx++) {
        node = elements.item(idx);
        field_name = node.getAttribute('name');
        field_type = node.getAttribute('type');
        // check file or image fields
        if(field_type == 'file' && perform_check){
            if(document.getElementById(field_name).value != ''){
               alert(DGVocabulary._MSG["need_upload_file"]);
               result_value_ff = false;
            }
        }
        field_full_name = 'wysiwyg' + field_name;                        
        if(document.getElementById(field_full_name)){
            document.getElementById(field_name).value = document.getElementById(field_full_name).contentWindow.document.body.innerHTML;                            
            if((document.getElementById(field_name).value == '<br>') || (document.getElementById(field_name).value == '<p>&nbsp;</p>') || (document.getElementById(field_name).value == '<p> </p>') || (document.getElementById(field_name).value == '&lt;p&gt;&nbsp;&lt;/p&gt;')){
                document.getElementById(field_name).value = '';
            }
        }
    }
    return result_value_ff;
}

function changeColor(el, color){
   if(document.getElementById(el)){
      document.getElementById(el).style.backgroundColor = color;      
   }
}

//-->