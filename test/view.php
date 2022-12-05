<?php
// Include the database configuration file
include 'dbConfig.php';

// Get image data from database
$result = $db->query("SELECT imgData FROM image");
?>

<?php if($result->num_rows > 0){ ?>
    <div class="gallery">
        <?php while($row = $result->fetch_array()){ ?>
        <?php echo '<img src="'.base64_encode($row['imgData']).'"  alt="chien"/>' ?>
        <?php } ?>
    </div>
<?php }else{ ?>
    <p class="status error">Image(s) not found...</p>
<?php } ?>