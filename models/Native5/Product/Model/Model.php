<?php
namespace Native5\Product\Model;
class Model extends \Illuminate\Database\Eloquent\Model
{
	/**
	 * The rules associated with validation.
	 *
	 * @var array
	 */
	protected $rules = array();

	/**
	 * The errors associated with the validation.
	 *
	 * @var array
	 */
	protected $errors;

	/**
	 * validation of models.
	 *
	 * @var string
	 */
	public function validate($data)
	{
        // make a new validator object
		$v = Validator::make($data, $this->rules);

        // check for failure
		if ($v->fails())
		{
            // set errors and return false
			$this->errors = $v->errors();
			return false;
		}

        // validation pass
		return true;
	}

	public function errors()
	{
		return $this->errors;
	}
}


