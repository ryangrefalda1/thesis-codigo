<?php 
$directory = "C:/Users/Admin/AppData/Local/Codigo";

// Get an array of files starting with "savedata"
$files = glob($directory . '/savedata*');

// Sort the files based on their modification time (oldest first)
usort($files, function ($a, $b) {
    return filemtime($a) - filemtime($b);
});

foreach ($files as $file) {
    // Read the contents of the file
    $fileContents = file_get_contents($file);

    // Remove control characters
    $cleanedContents = preg_replace('/[[:cntrl:]]/', '', $fileContents);

    // Decode the cleaned JSON data
    $data = json_decode($cleanedContents, true);

    // Check if JSON decoding was successful
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON in file ' . $file . ': ' . json_last_error_msg());
    }

    // Now you can work with the $data array and the file's modification time
    echo "File: $file, Modification Time: " . date('Y-m-d H:i:s', filemtime($file)) . PHP_EOL . "<br>";
 
    echo PHP_EOL;
}

    foreach( $data as $value ) {
        echo 'mcHealth: ' . $value['mcHealth'] . '<br>';
        echo 'save_room: ' . $value['save_room'] . '<br>';
    }










?>