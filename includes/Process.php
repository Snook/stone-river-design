<?php

/**
 * Created by PhpStorm.
 * User: Ryan.Snook
 * Date: 12/5/2014
 * Time: 11:59 PM
 */
class Process
{
	static private $banned_words = array(
		'admin',
		'xaged',
		'themer',
		'fuck',
		'shit',
		'asshole',
		'cunt',
		'fag',
		'fuk',
		'fck',
		'fcuk',
		'assfuck',
		'assfucker',
		'fucker',
		'motherfucker',
		'asscock',
		'asshead',
		'asslicker',
		'asslick',
		'assnigger',
		'nigger',
		'asssucker',
		'bastard',
		'bitch',
		'bitchtits',
		'bitches',
		'bitch',
		'brotherfucker',
		'bullshit',
		'bumblefuck',
		'buttfucka',
		'fucka',
		'buttfucker',
		'buttfucka',
		'fagbag',
		'fagfucker',
		'faggit',
		'faggot',
		'faggotcock',
		'fagtard',
		'fatass',
		'fuckoff',
		'fuckstick',
		'fucktard',
		'fuckwad',
		'fuckwit',
		'dick',
		'dickfuck',
		'dickhead',
		'dickjuice',
		'dickmilk',
		'doochbag',
		'douchebag',
		'douche',
		'dickweed',
		'dyke',
		'dumbass',
		'dumass',
		'fuckboy',
		'fuckbag',
		'gayass',
		'gayfuck',
		'gaylord',
		'gay',
		'gaytard',
		'nigga',
		'nigger',
		'niggers',
		'niglet',
		'paki',
		'piss',
		'prick',
		'pussy',
		'poontang',
		'poonany',
		'porchmonkey',
		'poon',
		'queer',
		'queerbait',
		'queerhole',
		'queef',
		'renob',
		'rimjob',
		'ruski',
		'sandnigger',
		'schlong',
		'shitass',
		'shitbag',
		'shitbagger',
		'shitbreath',
		'chinc',
		'carpetmuncher',
		'chink',
		'choad',
		'clitface',
		'clusterfuck',
		'cockass',
		'cockbite',
		'cockface',
		'skank',
		'skeet',
		'skullfuck',
		'slut',
		'slutbag',
		'splooge',
		'twatlips',
		'twat',
		'twats',
		'twatwaffle',
		'vaj',
		'vajayjay',
		'vajj',
		'wank',
		'wankjob',
		'wetback',
		'whore',
		'whorebag',
		'whoreface'
	);

	static function deleteImgur($imgur_id, $is_deleted)
	{
		$STH = Database::prepare("UPDATE `themer_imgur` SET `is_deleted` = :is_deleted  WHERE `imgur_id` = :imgur_id");
		$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
		$STH->bindValue(':is_deleted', $is_deleted, PDO::PARAM_INT);
		$STH->execute();

		if (!empty($is_deleted))
		{
			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Hidden imgur',
				'button_txt' => 'Un-Hide'
			));
			exit;
		}
		else
		{
			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Unhide imgur',
				'button_txt' => 'Hide'
			));
			exit;
		}
	}

	static function removeCategory($imgur_id, $cat_id)
	{
		if ($cat_id == '6')
		{
			$STH = Database::prepare("UPDATE `themer_imgur` SET `nsfw` = :nsfw  WHERE `imgur_id` = :imgur_id");
			$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
			$STH->bindValue(':nsfw', 0, PDO::PARAM_INT);
			$STH->execute();
		}
		else
		{
			$STH = Database::prepare("DELETE FROM `themer_imgur_to_category` WHERE imgur_id = :imgur_id AND `category_id` = :cat_id");
			$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
			$STH->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
			$STH->execute();
		}

		echo json_encode(array(
			'processor_success' => true,
			'processor_message' => 'Removed category'
		));
		exit;
	}

	static function addNewCategory($imgur_id, $new_cat_name, $new_cat_short_name, $new_cat_parent)
	{
		$cat_info = Database::f("SELECT * FROM `themer_category` WHERE `short_name` = '" . $new_cat_short_name . "'");

		if (!$cat_info)
		{
			$STH = Database::prepare("INSERT INTO `themer_category` (`category_name`, `short_name`, `parent`) VALUES (:category_name, :short_name, :parent)");
			$STH->bindValue(':category_name', $new_cat_name, PDO::PARAM_STR);
			$STH->bindValue(':short_name', $new_cat_short_name, PDO::PARAM_INT);
			$STH->bindValue(':parent', $new_cat_parent, PDO::PARAM_INT);
			$STH->execute();

			$cat_info = Database::f("SELECT * FROM `themer_category` WHERE `short_name` = '" . $new_cat_short_name . "'");

			$result = self::addCategory($imgur_id, $cat_info->id);
		}

		return $result;
	}

	static function addCategory($imgur_id, $cat_id)
	{
		$cat_info = Database::f("SELECT * FROM `themer_category` WHERE `id` = '" . $cat_id . "'");

		$success = false;

		if ($cat_info->parent)
		{
			self::addCategory($imgur_id, $cat_info->parent);
		}

		if ($cat_id == '6')
		{
			$cat_exists = Database::f("SELECT * FROM `themer_imgur` WHERE `imgur_id` = '" . $imgur_id . "'");

			if (empty($cat_exists->nsfw))
			{
				$STH = Database::prepare("UPDATE `themer_imgur` SET `nsfw` = :nsfw  WHERE `imgur_id` = :imgur_id");
				$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
				$STH->bindValue(':nsfw', 1, PDO::PARAM_INT);
				$STH->execute();

				$success = true;
			}
		}

		$cat_exists = Database::f("SELECT * FROM `themer_imgur_to_category` WHERE imgur_id = '" . $imgur_id . "' AND category_id = '" . $cat_id . "'");

		if (!$cat_exists && !empty($imgur_id) && !empty($cat_id))
		{
			$STH = Database::prepare("INSERT INTO `themer_imgur_to_category` (`imgur_id`, `category_id`) VALUES (:imgur_id, :cat_id)");
			$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
			$STH->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
			$STH->execute();

			$success = true;
		}

		return json_encode(array(
			'processor_success' => $success,
			'processor_message' => 'Added category'
		));
	}

	static function toggleAccountPublicFavorite($User, $pub_fav)
	{
		$STH = Database::prepare("UPDATE `themer_user` SET `public_favorites` = :public_favorites WHERE `id` = :id");
		$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
		$STH->bindValue(':public_favorites', $pub_fav, PDO::PARAM_STR);
		$STH->execute();

		echo json_encode(array(
			'processor_success' => true,
			'processor_message' => 'Public favorites updated.',
			'is_pub_fav' => ((!empty($pub_fav)) ? true : false),
		));
		exit;
	}

	static function toggleAccountPublicReddit($User, $pub_reddit)
	{
		$STH = Database::prepare("UPDATE `themer_user` SET `public_reddit` = :public_reddit WHERE `id` = :id");
		$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
		$STH->bindValue(':public_reddit', $pub_reddit, PDO::PARAM_STR);
		$STH->execute();

		echo json_encode(array(
			'processor_success' => true,
			'processor_message' => 'Public reddit updated.',
			'is_pub_fav' => ((!empty($pub_reddit)) ? true : false),
		));
		exit;
	}

	static function toggleAccountPublicImgur($User, $pub_imgur)
	{
		$STH = Database::prepare("UPDATE `themer_user` SET `public_imgur` = :public_imgur WHERE `id` = :id");
		$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
		$STH->bindValue(':public_imgur', $pub_imgur, PDO::PARAM_STR);
		$STH->execute();

		echo json_encode(array(
			'processor_success' => true,
			'processor_message' => 'Public imgur updated.',
			'is_pub_fav' => ((!empty($pub_imgur)) ? true : false),
		));
		exit;
	}

	static function toggleFavorite($User, $imgur_id)
	{
		$Favorite = Database::f("SELECT * FROM `themer_favorite` WHERE user_id = '" . $User->id . "' AND imgur_id = '" . $imgur_id . "'");

		if (empty($Favorite))
		{
			$STH = Database::prepare("INSERT INTO `themer_favorite` (`user_id`, `imgur_id`, `date_added`, `date_updated`) VALUES (:id, :imgur_id, :date_added, :date_updated)");
			$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
			$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
			$STH->bindValue(':date_added', TIMENOW, PDO::PARAM_INT);
			$STH->bindValue(':date_updated', TIMENOW, PDO::PARAM_INT);
			$STH->execute();

			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Set favorite',
				'is_fav' => true
			));
			exit;
		}
		else
		{
			$STH = Database::prepare("DELETE FROM `themer_favorite` WHERE user_id = :id AND `imgur_id` = :imgur_id");
			$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
			$STH->bindValue(':imgur_id', $imgur_id, PDO::PARAM_STR);
			$STH->execute();

			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Unset favorite',
				'is_fav' => false
			));
			exit;
		}
	}

	static function updateUsername($User, $name)
	{
		$name = substr(trim($name), 0, 20);

		if (strtolower($name) == 'me')
		{
			echo json_encode(array(
				'processor_success' => false,
				'processor_message' => 'Username taken.',
			));
			exit;
		}

		if ($name == '' || ctype_alnum($name))
		{
			$STH = Database::prepare("UPDATE `themer_user` SET `username` = :username WHERE `id` = :id");
			$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
			$STH->bindValue(':username', $name, PDO::PARAM_STR);
			$STH->execute();

			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Username updated.',
			));
			exit;
		}
	}

	static function checkUsername($name)
	{
		$name = substr(trim($name), 0, 20);

		if (strtolower($name) == 'me')
		{
			echo json_encode(array(
				'processor_success' => false,
				'processor_message' => 'Username taken.',
			));
			exit;
		}

		if (in_array(strtolower($name), self::$banned_words))
		{
			echo json_encode(array(
				'processor_success' => false,
				'processor_message' => 'Username taken.',
			));
			exit;
		}

		if (ctype_alnum($name))
		{
			$User = Database::f("SELECT * FROM `themer_user` WHERE LOWER(username) = '" . $name . "'");

			if (!empty($User))
			{
				echo json_encode(array(
					'processor_success' => false,
					'processor_message' => 'Username taken.',
				));
				exit;
			}
			else
			{
				echo json_encode(array(
					'processor_success' => true,
					'processor_message' => 'Username available.',
				));
				exit;
			}
		}
		else if ($name == '')
		{
			echo json_encode(array(
				'processor_success' => true,
				'processor_message' => 'Username available.',
			));
			exit;
		}
		else
		{
			echo json_encode(array(
				'processor_success' => false,
				'processor_message' => 'Invalid username.',
			));
			exit;
		}
	}
}

?>