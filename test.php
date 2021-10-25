<?php
require("classes/database.php");

use DB\db;

if($_POST)
{
    if(isset($_POST['content']))
    {
        $database = new db();
        $conn = $database->getConnection();
        $sql = "insert into text (header, text) values ('Můj header', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_POST['content']]);
        if($stmt->rowCount() == -1 || $stmt->rowCount() == 0)
        {
            $stmt=null;
            die("Error inserting new post");
        }

        echo("Post inserted");
        $stmt=null;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tiny.cloud/1/cn1rqadcaivd2h5gfu98endasaenuof7n7zcl8ivx8fyc2gq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
  <script>
      console.log("test");
      tinymce.init({
          selector: 'textarea',
          menubar: false,
          font_formats: "Play Fair=Playfair Display, serif; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; " +
              "Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; " +
              "Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; " +
              "Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; " +
              "Webdings=webdings; Wingdings=wingdings,zapf dingbats",
          content_style:  "body { font-family: Play Fair; }",
          plugins: 'image autolink lists table code link',
          toolbar: 'image code aligncenter alignjustify alignleft alignright alignnone bold' +
              ' fontsizeselect fontselect h2 italic underline undo link unlink bulllist numlist',
          toolbar_mode: 'floating',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',

          images_upload_url : 'upload.php',
          automatic_uploads : true,

      });
  </script>

  <form method="post">
      <textarea rows="50" name="content">
        Welcome to TinyMCE!
      </textarea>
      <input type="submit" name="save" value="Submit" />
      <input type="reset" name="reset" value="Reset" />
  </form>
<?php if(isset($message)) { echo $message; } ?>
</body>
</html>