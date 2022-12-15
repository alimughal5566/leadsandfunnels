<?php
//Cron Job file
//Created Date:22-07-2020 Created By: Muhammad Zulfiqar
//Delete canceled user after 90 days
// Starts execution
include_once('CronJob.php');
CronJob::getInstance()->clientAccountCancellation();
