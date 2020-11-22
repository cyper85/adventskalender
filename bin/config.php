<?php

const ADVENT_FILES = array(
    1 => "../files/uno.doc",
    2 => "../files/deux.txt",
);

const YEAR= 2020;

const SUCCESS = array(
    "http_status_code" => 200,
    "status" => "SUCCESS",
    "message"=>"");
const ERROR_OUT_OF_RANGE = array(
    "http_status_code" => 400,
    "status" => "ERROR_OUT_OF_RANGE",
    "message"=>"GET-Parameter monthday hat einen ungültigen Wert.");
const ERROR_TO_EARLY = array(
    "http_status_code" => 403,
    "status" => "ERROR_TO_EARLY",
    "message"=>"Du bist zu ungeduldig. Du musst noch %ux schlafen gehen, bevor du dieses Türchen öffnen kannst.");
const ERROR_NOT_AVAILABLE = array(
    "http_status_code" => 404,
    "status" => "ERROR_NOT_AVAILABLE",
    "message"=>"Ups, da haben die Weihnachtswichtel geschlafen. Leider ist das Türchen noch nicht befüllt. Versuch es später noch einmal.");
