<?php

require_once '../config.php';
require_once '../include.php';

$directory = dirname(__FILE__) . "/../../media";
$directoryIterator = new DirectoryIterator($directory);

foreach ($directoryIterator as $directoryInfo) {
	if ($directoryInfo->isDir() && preg_match('/\d{3}/i', $directoryInfo->getFilename())) {

		$page = Page::findByDirectoryName($directoryInfo->getFilename());
		//if page not isset
		if (!$page) {
			// create new page
			$page = new Page();
			$page->name = $directoryInfo->getFilename();
			$page->save();
		}
		echo $directory . '/' . $directoryInfo->getFilename() . "\n";
		$fileIterator = new DirectoryIterator($directory . '/' . $directoryInfo->getFilename());
		foreach ($fileIterator as $fileInfo) {
			if ($fileInfo->isFile() && preg_match('/\d{3}\.jpg$/i', $fileInfo->getFilename())) {
				$pageVersion = $page->findVersionByFileName($fileInfo->getFilename());
				// if page version not isset
				if (!$pageVersion) {
					// create new page version
					$pageVersion = new PageVersion();
					$pageVersion->name = $fileInfo->getFilename();
					$pageVersion->page_id = $page->id;
					$pageVersion->save();

					$image = new Imagick($fileInfo->getPathName());
					$image->thumbnailImage(170,109);
					if (!is_dir($directory . '/thumbnails/' . $page->name)) {
					    mkdir($directory . '/thumbnails/' . $page->name);
					}
					$image->writeImage($directory . '/thumbnails/' . $page->name . '/' . $fileInfo->getFilename());
				}
				echo $fileInfo->getFilename() . "\n";
			}
		}
	}

}

?>
