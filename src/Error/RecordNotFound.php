<?php namespace Chronicle\Error;

/*
    RecordNotFound exception handler, thrown when trying to access a record in a
    table where the record does not exist.
    @contributers Chris Head
*/

class RecordNotFound extends \Exception {}
