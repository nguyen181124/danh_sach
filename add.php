<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isvalid = true;
    if (empty($_POST["name"])) {
        $isvalid = false;
        $ename = "Hãy nhập tên";
    } elseif (is_numeric($_POST["name"])) {
        $isvalid = false;
        $ename = "Chỉ nhập chữ";
    } else {
        $name = $_POST['name'];
    }


    if (empty($_POST["birth"])) {
        $isvalid = false;
        $ebirth = "Hãy nhập năm sinh";
    } elseif (!is_numeric($_POST["birth"])) {
        $isvalid = false;
        $ebirth = "Chỉ nhập số";
    } else {
        $birth = $_POST['birth'];
    }

    if (empty($_POST["score"])) {
        $isvalid = false;
        $escore = "Hãy nhập điểm";
    } elseif (!is_numeric($_POST["score"])) {
        $isvalid = false;
        $escore = "Chỉ nhập số";
    } elseif (($_POST["score"]) > 10 || ($_POST["number"]) < 0) {
        $isvalid = false;
        $escore = "Chỉ nhập điểm từ 0 đến 10";
    } else {
        $score = $_POST['score'];
    }

    if ($isvalid) {
        $myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
        $user = [
            'name' => $name,
            'birth' => $birth,
            'score' => $score,
            'gender' => $_POST['gender']
        ];
        fwrite($myfile, json_encode($user) . "\n");
        fclose($myfile);
        header('Location: ' . '/list');

    }
}
$listuser = [];
$myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while (!feof($myfile)) {
    $user = json_decode(fgets($myfile), true);
    if ($user) {
        $listuser[] = $user;
    }

}
fclose($myfile);

$listuser = [];
$myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
while (!feof($myfile)) {
    $user = json_decode(fgets($myfile), true);
    if ($user) {
        $listuser[] = $user;
    }
}
fclose($myfile);
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <div class="flex justify-center">
        <div class="flex-col w-3/5">
            <p class="text-center text-5xl mt-7">Danh Sách</p>

            <table class="mx-auto mt-7" style="width:70%">
                <tr>
                    <th class="w-12">STT</th>
                    <th class="w-56">Tên</th>
                    <th>Giới tính</th>
                    <th>Năm Sinh</th>
                    <th>Điểm</th>
                    <th class="w-10"></th>
                </tr>
                <?php for ($i = 0; $i < count($listuser); $i++) { ?>
                    <tr>
                        <td>
                            <?php echo $i + 1; ?>
                        </td>
                        <td class="name-<?php echo $i ?>">
                            <?php echo $listuser[$i]["name"] ?>
                        </td>
                        <td>
                            <?php echo $listuser[$i]["gender"] ?>
                        </td>
                        <td>
                            <?php echo $listuser[$i]["birth"] ?>
                        </td>
                        <td>
                            <?php echo $listuser[$i]["score"] ?>
                        </td>
                        <td id="test" class="text-center"><input class="check" value="<?php echo $i; ?>" type="checkbox">
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <form class="table" action="" method="post">
            <div class="mt-12 ">
                <div class="flex flex-col">
                    <div class="flex">
                        Họ và tên<span class="text-red-600 block">*</span></div>
                    <input class="input_infor border-2 border-black" type="text" name="name"
                        value='<?php echo $name ?>'>
                    <span class="error text-red-600 block">
                        <?php echo $ename; ?>
                    </span>
                    <div class="flex">
                        Giới tính<span class="text-red-600 block">*</span></div>
                    <select class="input_infor border-2 border-black rounded-none min-h-7 bg-white" name="gender" id="">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                    <div class="flex">
                        Năm sinh<span class="text-red-600 block">*</span></div>
                    <input class="input_infor border-2 border-black" type="text" name="birth"
                        value='<?php echo $birth ?>'>
                    <span class="error text-red-600 block">
                        <?php echo $ebirth; ?>
                    </span>
                    <div class="flex">
                        Điểm<span class="text-red-600 block">*</span></div>
                    <input class="input_infor border-2 border-black" type="text" name="score"
                        value='<?php echo $score ?>'>
                    <span class="error text-red-600 block">
                        <?php echo $escore; ?>
                    </span>
                </div>
            </div>
            <div class="flex justify-end">
                <input class="save border-2 border-black max-w-max px-4 py-2 mt-4 " type="submit" name="Check"
                    value="Lưu" />
            </div>
            <br>
        </form>
        <span>
    </div>
</body>

<script>
    let test = document.getElementById("test");
    test.addEventListener("click", function () { })
</script>

</html>