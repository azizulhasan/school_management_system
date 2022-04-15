<?php
    require '././library/adminlibrary/model.php';
    require '././helper/helper.php';

    $crud = new Crud();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['submit'])){
                $eml = "";
                $psd = "";
            if($_POST['email'] == "" || empty($_POST['email']) || strlen(trim($_POST['email']))==0){
                 $eml .= "<div class='alert pl-5 form-control  alert-danger' role='alert'>Email Required</div>";
            }

            if($_POST['password'] == "" || empty($_POST['password']) || strlen(trim($_POST['password']))==0){
                $psd .= "<div class='alert pl-5 form-control  alert-danger' role='alert'>Password Required</div>";
            }
        }
    }
?>
<body>
  <section class="mt-3 mt-sm-3 mt-md-4 mt-lg-5">
    <div class="container ">
        <div class="row  login bg-light rounded">
          <?php
              if(isset($_POST['submit'])){
                  if($eml && $psd){
                      echo $eml . "<br>";
                      echo $psd;
                  }else{
                      $arr=[
                          'email'=>$_POST['email'],
                          'password'=> md5($_POST['password'])
                      ];
                      $type = $_POST['type'];
                      $results = "";

                      if($type == 1){
                        $results = $crud->ReadData("*", "admin",$arr  );

                        if($results->num_rows > 0){



                            while($d = $results->fetch_object()){

                                session_start();
                                $_SESSION['id'] = $d->id;
                                $_SESSION['name'] = $d->user_name;
                                $_SESSION['type'] = $d->type;

                                // echo "valid Email or Passowrd!!!";
                                Redirect('index.php?s=index');
                            }
                        }else{
                              echo "<div class='alert pl-5 form-control  alert-danger' role='alert'>Invalid user name or password</div>";
                        }

                      }else if($type == 2){
                        $results = $crud->ReadData("*", "student",  $arr);

                        if($results->num_rows > 0){
                            while($d = $results->fetch_object()){
                                session_start();
                                $_SESSION['id']           = $d->id;
                                $_SESSION['admission_id'] = $d->admission_id;
                                $_SESSION['studentId']    = $d->studentId;
                                $_SESSION['class_id']     = $d->class_id;
                                $_SESSION['type']         = $d->type;

                                Redirect('index.php?st=index');
                            }
                        }else{
                              echo "<div class='alert pl-5 form-control  alert-danger' role='alert'>Invalid user name or password</div>";
                        }

                      }else if($type == 3){
                        $results = $crud->ReadData("*", "teachers", $arr);

                        if($results->num_rows > 0){
                            while($d = $results->fetch_object()){
                                session_start();
                                $_SESSION['id'] = $d->id;
                                $_SESSION['name'] = $d->name;
                                $_SESSION['type'] = $d->type;
                                // echo "valid Email or Passowrd!!!";
                                Redirect('index.php?t=index');
                            }
                        }else{
                              echo "<div class='alert pl-5 form-control  alert-danger' role='alert'>Invalid user name or password</div>";
                        }

                      }
                  }
              }

              session_start();
              if(isset($_SESSION['type']) && $_SESSION['type']==1 && $_SESSION['id']){
                Redirect("index.php?s=index");
              }
          ?>
          <div class="col-sm-6 col-md-6 col-lg-4  p-2 px-md-5 pt-md-5">
            
            <h4 class="text-light bg-primary text-center py-2 ">Login as : Admin</h4>
            <ul >
              <li class="nav-link">Email : super@email.com</li>
              <li class="nav-link">Pass : 123</li>
            </ul>
            <h4 class="text-light bg-primary text-center py-2 ">Login as : Teacher</h4>
            <ul >
              <li class="nav-link">Email : rajin@email.com</li>
              <li class="nav-link">Pass : 789</li>
            </ul>

          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 p-2 px-md-5 pt-md-5">
            <h4 class="text-light bg-primary text-center py-2 ">Login as : Student</h4>
            <ul >
              <li class="nav-link">Email : anis@email.com</li>
              <li class="nav-link">Pass : 456</li>
            </ul>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="p-2 px-md-5 py-md-5">
              <form action="" method="post">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Login As</label>
                  <select name="type" class="form-control" id="exampleFormControlSelect1">
                    <?php
                      $type = $crud->ReadData("*", "users");
                      while($t = $type->fetch_object()){
                        echo "<option value='{$t->id}'>$t->name</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="text" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                  <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                  <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <input type="submit" class="btn btn-primary btn-user btn-block login-btn" name="submit" value="Login">
              </form>
            </div>
          </div>
          
        </div>
    </div>
  </section>
