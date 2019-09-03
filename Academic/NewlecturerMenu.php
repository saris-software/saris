
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="Academic/card.css?v=1.0" rel="stylesheet" type="text/css" />
    <style>


        .row {
            margin-top: 20px;
        }
        .card {
            border-top: 7px solid #263238;
            padding-top: 5%;
        }
        .card:focus, .card:hover {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 2px 5px 0 rgba(0, 0, 0, 0.20);
            /*box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.20);*/
        }
        .card-inverse .card-img-overlay {
            background-color: rgba(51, 51, 51, 0.85);
            border-color: rgba(51, 51, 51, 0.85);
        }
     .images{
height:150px;


}
h1{
  font-family: "Times New Roman", Times, serif;
   color:white;
   background-color:#b88cef;
}
    </style>
    <title>SARIS</title>

    <!--modernaizer here-->
    <script src="modernizr-custom.js">
    </script>
</head>
<body>
<div class="images" id="">
       <img width="100%" height="250px" src="./mnma.jpeg "/>
    </div>
<div class="header" id="">
<h1 style="font-size:40px; text-align:center; ">THE MWALIMU NYERERE MEMORIAL ACADEMY</h1>
    </div>
<!-- navbar -->

<nav class="navbar  navbar-default navbar-toggleable-md navbar-light bg-faded  sticky-top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand nav-link" href="studentindex.php"><img width="70" src="./logo.png "/>  SARIS SYSTEM</a>

<br><p style="font-size: 22px;"> Welcome to the Academic Module.</p><br><br>

    </div>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex flex-row flex-nowrap ml-auto mr-sm-5 mr-md-5 mr-lg-0">
            <li class="nav-item ">
                <a class="navbar-brand nav-link" href="#"><img class="rounded-circle" width="40"
                                                               src="./img/user.svg"/></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="../signout.php"><!--<img class="rounded-circle" width="40"
                                                                             src="./img/user.svg"/>--> Logout</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="studentUserManual.php"> Help</a>
            </li>
        </ul>

    </div>


</nav>
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="studentindex.php">Home</a>
    <a class="breadcrumb-item" href="javascript:history.back();">Back</a>
    <span class="breadcrumb-item active">Home</span>
</nav>

<div class="container text-muted">
    <!-- cards -->
    <div class="row">

        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="admissionRegistrationForm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/admission.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/help.php"><h5 class="card-title">Help</h5></a>
                </div>
            </div>
        </div> <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="academic_submenu/policy.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/accomodation.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/policy.php"><h5 class="card-title">Policy Setup</h5></a>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="gettimetable.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/timetable.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/administration.php"><h5 class="card-title">Administration</h5></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card" align="center">

                <a href="academicRecord.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/accademicrecord.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/examination.php"><h5 class="card-title">Examination</h5></a>

                </div>
            </div>
        </div>
<div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="studentcourseregisterednotes.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/elearning.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/timetable.php"><h5 class="card-title">Timetable</h5></a>

                </div>
            </div>
        </div>


        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="studentcourseregisterednotes.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/elearning.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/e_learning.php"><h5 class="card-title">E-Learning</h5></a>

                </div>
            </div>
        </div>


    </div>
          <div class="row">
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="admissionComm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/communication.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/communication.php"><h5 class="card-title">Communication</h5></a>

                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="/admissionSecurity.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./logo.png"></a>

                <div class="card-block">
                    <a href="academic_submenu/security.php"><h5 class="card-title">Security</h5></a>
                </div>
            </div>
        </div>
    <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="admissionRegistrationForm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/admission.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/help.php"><h5 class="card-title">Profile</h5></a>
                </div>
            </div>
       
    </div>

</div>
</div><!-- end .container -->
<br><br><br>
<!--footer-->
		<div class="copyright"><hr noshade style="color:#B9C2C6" size=1>

        <em>ZALONGWA-SARIS v5.0.2 

        </tr>

        </table>

        </body>

        </html>

        </em>
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<!--adding tooltip-->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!--Modernaizer here check if not svg supported replace with png-->
<script>
    if (!Modernizr.svg) var i = document.getElementsByTagName("img"), j, y;
    for (j = i.length; j--;) y = i[j].src, y.match(/svg$/) && (i[j].src = y.slice(0, -3) + "png")
</script>
</body>
</html>

