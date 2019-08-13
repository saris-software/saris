 <form enctype="multipart/form-data" action="zimport.php" method="post">
      <table width="512" border="1" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
         <tr>
            <th width="156" nowrap scope="row">
				<div align="right">
				  <input type="hidden" name="MAX_FILE_SIZE" value="55646039">
				  <input type="hidden" name="ayear" value="<?php echo $ayear ?>">
				  <input type="hidden" name="coursecode" value="<?php echo $key ?>">
				  <input type="hidden" name="examcat" value="<?php echo $examcat ?>">
				  <input type="hidden" name="sem" value="<?php echo $sem ?>">Choose File:
				</div>
			</th>
            <td colspan="2" nowrap><input name="userfile" type="file" size="35">
         </tr>
			<?php if ($privilege==2){ ?>
		 <tr>
            <th width="156" nowrap scope="row">
               <div align="right">Existing Data:</div></th>
			<td><input name="radiobutton" type="radio" value="1">Yes Overwrite </td>
			<td><input name="radiobutton" type="radio" value="0">Never Overwrite </td>					  
         </tr>
				<?php } ?>
		 <tr>
            <th scope="row">&nbsp;</th>
            <td width="153"><input type="submit" value="Send File"></td>
            <td width="232"><input type="reset" name="Reset" value="Reset"></td>
         </tr>
      </table>
 </form>
