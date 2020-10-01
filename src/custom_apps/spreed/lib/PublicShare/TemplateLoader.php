<?php

declare(strict_types=1);

/**
 *
 * @copyright Copyright (c) 2018, Daniel Calviño Sánchez (danxuliu@gmail.com)
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Talk\PublicShare;

use OCA\Talk\Config;
use OCA\Talk\TInitialState;
use OCP\EventDispatcher\IEventDispatcher;
use OCP\Files\FileInfo;
use OCP\ICacheFactory;
use OCP\IConfig;
use OCP\IInitialStateService;
use OCP\Share\IShare;
use OCP\Util;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Helper class to extend the "publicshare" template from the server.
 *
 * The "loadTalkSidebarUi" method loads additional scripts that, when run on the
 * browser, adjust the page generated by the server to inject the Talk UI as
 * needed.
 */
class TemplateLoader {
	use TInitialState;

	public function __construct(IInitialStateService $initialStateService,
								ICacheFactory $memcacheFactory,
								Config $talkConfig,
								IConfig $serverConfig) {
		$this->initialStateService = $initialStateService;
		$this->talkConfig = $talkConfig;
		$this->memcacheFactory = $memcacheFactory;
		$this->serverConfig = $serverConfig;
	}

	public static function register(IEventDispatcher $dispatcher): void {
		$dispatcher->addListener('OCA\Files_Sharing::loadAdditionalScripts', static function (GenericEvent $event) {
			/** @var IShare $share */
			$share = $event->getArgument('share');
			/** @var self $templateLoader */
			$templateLoader = \OC::$server->query(self::class);
			$templateLoader->loadTalkSidebarUi($share);
		});
	}

	/**
	 * Load the "Talk sidebar" UI in the public share page for the given share.
	 *
	 * This method should be called when loading additional scripts for the
	 * public share page of the server.
	 *
	 * @param IShare $share
	 */
	public function loadTalkSidebarUi(IShare $share): void {
		if ($this->serverConfig->getAppValue('spreed', 'conversations_files', '1') !== '1' ||
			$this->serverConfig->getAppValue('spreed', 'conversations_files_public_shares', '1') !== '1') {
			return;
		}

		if ($share->getNodeType() !== FileInfo::TYPE_FILE) {
			return;
		}

		Util::addStyle('spreed', 'merged-public-share');
		Util::addScript('spreed', 'talk-public-share-sidebar');

		$this->publishInitialStateForGuest();
	}
}
