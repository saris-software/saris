<?php 
if (($sponsor=='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') 
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";
}elseif (($sponsor=='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme!='0') ){
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') 
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";
}elseif (($sponsor=='0') and ($stream=='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
      					(student.Status='$status') 
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";
}elseif (($sponsor!='0') and ($stream!='0') and ($status=='0')  and ($cohort!='0') and ($programme!='0') ){	
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
      					(student.Class='$stream')  AND
      					(student.Sponsor='$sponsor') 
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor=='0') and ($stream!='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){	
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
      					(student.Class='$stream') AND
      					(student.Status='$status') 
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor!='0') and ($stream!='0') and ($status!='0') and ($cohort!='0') and ($programme!='0') ){	
	$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
      					(student.Class='$stream') AND
      					(student.Status='$status') AND
						(student.Sponsor='$sponsor')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor=='0') and ($stream!='0') and ($status=='0')  and ($cohort!='0') and ($programme!='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
						(student.Class='$stream')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor!='0') and ($stream=='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.ProgrammeofStudy='$programme') AND
						(student.Sponsor='$sponsor')AND
      					(student.Status='$status')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor=='0') and ($stream=='0') and ($status!='0') and ($cohort!='0') and ($programme=='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.Status='$status')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor=='0') and ($stream!='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.Class='$stream')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor!='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.Sponsor='$sponsor')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}elseif (($sponsor!='0') and ($stream=='0') and ($status!='0') and ($cohort!='0') and ($programme=='0') ){	
		$sql = "SELECT student.Id,
				   student.Name,
				   student.RegNo,
				   student.Sex,
				   student.EntryYear,
				   student.Sponsor,
				   student.Status,
				   student.Class,
				   student.ProgrammeofStudy
       
				FROM student
				WHERE 
  					 (
      					(student.EntryYear='$cohort') AND
      					(student.Sponsor='$sponsor') AND
      					(student.Status='$status')
   					 )
								ORDER BY
								student.ProgrammeofStudy, 
								student.Class, 
								student.Name";	
}
	$query_std = @mysql_query($sql);
?>	