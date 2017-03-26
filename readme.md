# S3 Database saver
##Getting started

 1. Install s3cmd

 `sudo apt-get install s3cmd`

 2. Configure s3cmd with your AWS Access key and AWS Secret keys

	`s3cmd --configure`

 3. Run the s3dbsaver.php

	`php s3dbsaver.php --db-name={dbname} --db-user={dbuser} --db-pass={dbpass} --s3-bucket={s3_bucket}`
