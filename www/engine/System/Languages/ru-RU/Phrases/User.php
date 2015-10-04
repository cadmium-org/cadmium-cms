<?php

return [

	# Errors

	'USER_ERROR_MODIFY'                             => 'Ошибка сохранения данных пользователя',

	'USER_ERROR_AUTH_LOGIN'                         => 'Ошибка авторизации',
	'USER_ERROR_AUTH_RESET'                         => 'Ошибка восстановления пароля',
	'USER_ERROR_AUTH_RECOVER'                       => 'Ошибка изменения пароля',
	'USER_ERROR_AUTH_REGISTER'                      => 'Ошибка регистрации',

	'USER_ERROR_EDIT_PERSONAL'                      => 'Ошибка сохранения личных данных',
	'USER_ERROR_EDIT_PASSWORD'                      => 'Ошибка изменения пароля',

	'USER_ERROR_NAME_INVALID'                       => 'Неверный формат имени пользователя',
	'USER_ERROR_NAME_INCORRECT'                     => 'Пользователь с таким именем не найден',
	'USER_ERROR_NAME_DUPLICATE'                     => 'Пользователь с таким именем уже существует',
	'USER_ERROR_EMAIL_INVALID'                      => 'Неверный формат e-mail',
	'USER_ERROR_EMAIL_DUPLICATE'                    => 'Пользователь с таким e-mail\'ом уже существует',
	'USER_ERROR_PASSWORD_INVALID'                   => 'Неверный формат пароля',
	'USER_ERROR_PASSWORD_INCORRECT'                 => 'Неверный пароль',
	'USER_ERROR_PASSWORD_MISMATCH'                  => 'Пароли не совпадают',
	'USER_ERROR_PASSWORD_NEW_INVALID'               => 'Неверный формат нового пароля',
	'USER_ERROR_CAPTCHA_INCORRECT'                  => 'Неверный код проверки',

	'USER_ERROR_ACCESS'                             => 'Ваш аккаунт заблокирован администрацией',

	# Success messages

	'USER_SUCCESS_SAVE'                             => 'Данные пользователя были успешно сохранены!',

	'USER_SUCCESS_RESET'                            => 'Вы запросили восстановление пароля!',
	'USER_SUCCESS_RESET_TEXT'                       => 'Дальнейшие инструкции были отправлены на ваш e-mail адрес',

	'USER_SUCCESS_RECOVER'                          => 'Пароль был успешно изменен!',
	'USER_SUCCESS_RECOVER_TEXT'                     => 'Вы можете авторизироваться, используя ваш новый пароль',

	'USER_SUCCESS_REGISTER'                         => 'Регистрация была успешно завершена!',
	'USER_SUCCESS_REGISTER_TEXT'                    => 'Вы можете авторизироваться, используя ваше имя пользователя и пароль',

	'USER_SUCCESS_EDIT'                             => 'Данные были успешно сохранены!',

	# Fields

	'USER_FIELD_CAPTCHA'                            => 'Код проверки',
	'USER_FIELD_CITY'                               => 'Город',
	'USER_FIELD_COUNTRY'                            => 'Страна',
	'USER_FIELD_EMAIL'                              => 'E-mail',
	'USER_FIELD_FIRST_NAME'                         => 'Имя',
	'USER_FIELD_LAST_NAME'                          => 'Фамилия',
	'USER_FIELD_NAME'                               => 'Имя пользователя',
	'USER_FIELD_PASSWORD'                           => 'Пароль',
	'USER_FIELD_PASSWORD_CURRENT'                   => 'Текущий пароль',
	'USER_FIELD_PASSWORD_NEW'                       => 'Новый пароль',
	'USER_FIELD_PASSWORD_RETYPE'                    => 'Подтверждение пароля',
	'USER_FIELD_RANK'                               => 'Уровень доступа',
	'USER_FIELD_SEX'                                => 'Пол',
	'USER_FIELD_TIMEZONE'                           => 'Часовая зона',

	# Other

	'USER_UNKNOWN'                                  => 'Неизвестный пользователь'
];
