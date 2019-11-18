<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        #sbody {
            width: 80%;
            margin: 0% 10%;
        }

        #boardtitle {
            width: 100%;
            height: 60px;
            text-align: center;
            background-color: rgb(221, 185, 23);
        }
    </style>
</head>

<body>
    <div id="sbody">
        <div class="jumbotron jumbotron-fluid" style="background-color: rgb(221, 185, 23)">
            <div class="container">
                <h1 class="display-4" style="text-align:center ">留言板</h1>
            </div>
        </div>
        <form>
            <div class="form-group">
                <label for="sName">暱稱：</label>
                <textarea class="form-control" id="sName" rows="1"></textarea>
            </div>
            <div class="form-group">
                <label for="sMessage">內容：</label>
                <textarea class="form-control" id="sMessage" rows="3"></textarea>
            </div>
            <!-- <input type="button" value="留言" id="leaveMessage"> -->
            <button type="button" class="btn btn-info" id="leaveMessage">留言</button>
        </form>
        <hr>
        <div>
            <?php
                $oLink = mysqli_connect('localhost', 'root', '', 'board');
                $oResult = mysqli_query($oLink, "select * from Data");
                $iTotalRow = mysqli_num_rows($oResult);
                echo "<table width='800' align='center' class='table table-striped'>";
                echo "<tbody>";
                for ($i = 0; $i < $iTotalRow; $i++) {
                    $aRow = mysqli_fetch_assoc($oResult);
                    echo "<tr>";
                    // echo "<td class='rowname'>姓名：" . $aRow['Name'] . "</td>";
                    // echo "<td class='roemessage'>訊息：" . $aRow['Message'] . "</td>";
                    echo "<td colspan='5'>";
                    echo '<li class="media">
                    <img src="user.png" class="mr-3 align-self-center" alt="..." style="width:50px">
                    <div class="media-body">
                      <h5 class="mt-0 mb-1"><strong>'.$aRow['Name'].'</strong></h5>'.
                      $aRow['Message'].'
                    </strong>
                  </li>';
                    echo "</td>";
                    echo "<td style='text-align:right' id=" . $aRow['id'] . "><button type='button' style='margin:0px 5px' class='oUpdate btn btn-primary'  data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo'>修改</button>";
                    echo "<button type='button' class='oDelete btn btn-danger'>刪除</button></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            ?>
        </div>
        <div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">修改</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="changeName" class="col-form-label">帳號:</label>
            <input type="text" class="form-control" id="changeName">
          </div>
          <div class="form-group">
            <label for="changeMessage" class="col-form-label">訊息:</label>
            <textarea class="form-control" id="changeMessage"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary save">儲存</button>
      </div>
    </div>
  </div>
</div>





        </div>

    </div>

    <script>
        $(document).ready(function () {

            $("#leaveMessage").click(function () {
                var sNametext = $("#sName").val();
                var sMessagetext=$("#sMessage").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "http://localhost/board/create.php",
                    data: {
                        "nametext": sNametext,
                        "messagetext": sMessagetext,
                    },
                    success: function () {
                        location.reload()

                    }
                })
            })

            $(".oDelete").click(function(){
                var iID=$(this).parent().attr("id");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "http://localhost/board/delete.php",
                    data: {
                        "deleteID":iID,
                    },
                    success: function () {
                        location.reload();

                    }
                })
            })
            var iCHID;
            $(".oUpdate").click(function(){
                iCHID=$(this).parent().attr("id");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        method: "POST",
                        url: "http://localhost/board/update.php",
                        data: {
                            "updateID": iCHID,
                            "show": "",

                        },
                        success: function ($_sResponse) {
                            var aResponsedata=JSON.parse($_sResponse);
                            // alert(responsedata.dataname);
                            $("#changeName").val(aResponsedata.dataname);
                            $("#changeMessage").val(aResponsedata.datamessage);
                         }
                    })
            })

            $(".save").click(function(){
                    var sNewName=$("#changeName").val();
                    var sNewMessage=$("#changeMessage").val();
                    // console.log(iCHID);
                    // console.log(sNewName);
                    // console.log(sNewMessage);
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        method: "POST",
                        url: "http://localhost/board/update.php",
                        data: {
                            "updateID": iCHID,
                            "NewName": sNewName,
                            "NewMessage": sNewMessage,

                        },
                        success: function () {
                            location.reload();
                            // alert("123");
                         }
                    })
                })

        })
    </script>
</body>

</html>