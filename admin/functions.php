<?php 
  function insert_categories() {
    global $connection;

    if(isset($_POST['submit'])) {
      $cat_title = $_POST['cat_title'];

      if($cat_title == "" || empty($cat_title)) {
        echo "This field should not be empty!";
      } else {
        $query = "INSERT INTO categories(cat_title)";
        $query .= "VALUES('{$cat_title}')";

        $create_category_query = mysqli_query($connection, $query);

        if(!$create_category_query) {
          die("Query failed!". mysqli_error($connection));
        }
      }
    }
  }
?>

<?php 
  function findAllCategories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo 
        "<tr>
          <td>{$cat_id}</td>
          <td>{$cat_title}</td>
          <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
          <td><a href='categories.php?update={$cat_id}'>Update</a></td>
        </tr>";
    }
  }
?>

<?php 
  function delete_categories() {
    global $connection;
    if (isset($_GET['delete'])) {
      $the_cat_id = $_GET['delete'];
      $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
      $delete_query = mysqli_query($connection, $query);
      header("Location: categories.php");
    }
  }
?>

<?php 
  function confirm($result) { 
    global $connection;
    if (!$result) {
      die("Query failed " . mysqli_error($connection));
    }
}
?>