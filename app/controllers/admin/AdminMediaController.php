<?php
use Intervention\Image\ImageManagerStatic as Image;

class AdminMediaController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Inject the models.
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		parent::__construct();
		$this->user = $user;
	}

	/*
	 *
	 */
	public function image($filename = '', $width = 50, $heigh = 50)
	{
		$lifeTime = Config::get('imagecache::config.lifetime');
		$small = Config::get('imagecache::config.templates');

		$width = ((int) $width > (int) 50) ? 50 : $width;

		$path = public_path() . '/upload/images/' . $filename;
		$file = Image::make($path);

		$imgObj = Image::cache(function($image) use($width, $path)
		{
			if( ! is_file($path))
			{
				$color = '#ddd';
				$image->resize((int) $width, 50, null);
				$image->fill('#fff');
				$image->line($color, 0, 0, $width, $width);
				$image->line($color, $width, 0, 0, $width);
				$image->rectangle($color, 0, 0, ($width -1), ($width -1), false);
			}
			else
			{
				$image = $image->make($path)->resize((int) $width, 50, null);
			}

			return $image;

		}, $lifeTime, true);

		return Response::make($imgObj, 200)
			->header('Content-Type', (isset($file->mime) ? $file->mime : 'image/jpeg'));
	}
}
