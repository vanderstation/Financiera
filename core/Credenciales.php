<?php

const DB_HOST = "localhost";
const DB_NAME = "financiera";
const DB_PORT = "5432";
const DB_USER = "root";
const DB_PASS = "root1234";

const DNS = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;

#esto es para los hash las convinaciones
const METHOD = "AES-256-CBC";
const SECRET_KEY = '$FINANCIERA@2019';
const SECRET_IV = '170211';
