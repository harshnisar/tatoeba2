<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */

$messageId = $message['Wall']['id'];

$this->pageTitle = sprintf(__("Edit message %s", true), $messageId) ; 
?>
<div id="annexe_content">
    <div class="module">
        <h2><?php __("Menu"); ?></h2>
        <p>
            <?php
            echo $html->link(
                __('Back to Wall', true),
                array(
                    'controller' => 'wall',
                    'action' => 'index',
                    "{$message['Wall']['id']}#message_{$message['Wall']['id']}"
                )
            );
            ?>
        </p>
    </div>
</div>

<div id="main_content">
    
    <!-- <div class="module" style="display:none"> -->
        <?php
        /*
        // Users are not suppoed to the able to post new message from here,
        // but we need the form so that the Javascript works properly.
        // TODO display:none is hackish for accessibility reason 
        // but i agree it's my own :(
        if ($isAuthenticated) {
            echo '<div id="sendMessageForm">'."\n";
            echo $wall->displayAddMessageToWallForm();
            echo '</div>'."\n";
        }
         * */
        ?>
    <!-- </div> -->
    
    
    <div class="module" >
        <h2><?php __("Edit Wall Message"); ?></h2>
    <?php
        $wall->displayEditMessageForm($message);
    ?>
    </div>
    
</div>
