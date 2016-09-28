<?php

class DataStruct extends Eloquent{
	protected $table = 'files';
	protected $fillable = array('path','disppath','name','dispname','type','datec','size','ownergroup','owner');
	public $timestamps = false;
}