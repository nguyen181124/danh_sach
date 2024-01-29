<?php
function writeToFile($file, $content, $mode = 'a+')
{
  try {
    $myfile = fopen($file, $mode) or die("Unable to open file!");
    fwrite($myfile, $content . "\n");
    fclose($myfile);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

function deleteFile($file)
{
  $myfile = fopen($file, 'w') or die("Unable to open file!");
  fwrite($myfile, '');
  fclose($myfile);
}
function readFileFrom($file)
{
  $lists = [];
  $myfile = fopen($file, "r") or die("Unable to open file!");
  while (!feof($myfile)) {
    if ($content = fgets($myfile)) {
      $lists[] = json_decode($content, true);

    }

  }
  fclose($myfile);
  return $lists;
}
$pathFile = "newfile.txt";
$lists = readFileFrom($pathFile);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($selects = $_POST['select']) {
    foreach ($selects as $index) {
      array_splice($lists, $index, 1);
    }
  }
  deleteFile($pathFile);

  foreach ($lists as $student) {
    writeToFile($pathFile, json_encode($student));
  }

}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  </style>


</head>

<body>
  <main class="container mx-auto pt-10">
    <form action="" method="POST" class="flex gap-20 justify-center">
      <div class="lg:w-1/2">
        <p class="text-center text-5xl mt-7">Danh Sách</p>
        <table class="w-full border border-collapse">
          <thead class="text-left">
            <th class="border px-4 py-2">STT</th>
            <th class="border px-4 py-2">Tên</th>
            <th class="border px-4 py-2">Giới tính</th>
            <th class="border px-4 py-2">Năm sinh</th>
            <th class="border px-4 py-2">Điểm</th>
            <th class="border px-4 py-2"></th>
          </thead>
          <tbody>
            <?php foreach ($lists as $key => $value) { ?>
              <tr class="student-<?php echo $key ?>">
                <td class="border px-4 py-2">
                  <?php echo $key + 1 ?>
                </td>
                <td class="name border px-4 py-2">
                  <?php echo $value['name'] ?>
                </td>
                <td class="gender border px-4 py-2">
                  <?php echo $value['gender'] ?>
                </td>
                <td class="birth border px-4 py-2">
                  <?php echo $value['birth'] ?>
                </td>
                <td class="score border px-4 py-2">
                  <?php echo $value['score'] ?>
                </td>
                <td class="border px-4 py-2"><input class="select" onclick="edit(event)" value="<?php echo $key; ?>"
                    name="select[]" type="checkbox"></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <form action="" method="post">
        <div class="mt-12 ">
          <div class="flex flex-col">
            Họ và tên
            <input disabled  class="name input_infor border-2" name="name" type="text"/>
            <span class="error text-red-600 block">
              <?php echo $ename; ?>
            </span>
            Giới tính 
            <select class="input_infor border-2  rounded-none min-h-7 bg-white" name="gender" disabled>
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
              <option value="Khác">Khác</option>
            </select>
            Năm sinh 
            <input disabled  class="birth input_infor border-2" name="birth" type="text"/>
            <span class="error text-red-600 block">
              <?php echo $ebirth; ?>
            </span>
            Điểm 
            <input disabled  class="score input_infor border-2" name="score" type="text"/>
            <span class="error text-red-600 block">
              <?php echo $escore; ?>
            </span>
          </div>
          <div class="submit flex mt-4 justify-between">
            <a href="/add" class="flex border-2 border-black p-2 w-20"> Thêm </a>
            <a href="/edit" class="edit border-2 border-black p-2 w-20"> Sửa </a>
            <button type="submit" onclick="confirm('Bạn có chắn chắn muốn xóa dữ liệu?')"
              class="border-2 border-black p-2 w-20"> Xóa </button>
          </div>
      </form>
    </form>

  </main>
  <script>
    let inputName = document.querySelector('input.name');
    let inputGender = document.querySelector('input.gender')
    let inputBirthday = document.querySelector('input.birth');
    let inputScore = document.querySelector('input.score');
    let editLinkElement = document.querySelector('a.edit');
    function edit(e) {
      if (e.target.checked) {
        let trElement = document.querySelector(`tr.student-${e.target.value}`);
        inputName.value = trElement.querySelector('td.name').innerHTML;
        inputGender.value = trElement.querySelector('td.gender').innerHTML;
        inputBirthday.value = trElement.querySelector('td.birth').innerHTML;
        inputScore.value = trElement.querySelector('td.score').innerHTML;
        editLinkElement.href = "edit?" + `index=${e.target.value}`;
      }
      else {
        inputName.value = '';
        inputBirthday.value = '';
        inputScore.value = '';
        editLinkElement.href = '#';
      }
    }
  </script>
</body>

</html>