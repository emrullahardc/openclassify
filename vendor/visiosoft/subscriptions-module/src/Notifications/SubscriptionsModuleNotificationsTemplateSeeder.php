<?php namespace Visiosoft\SubscriptionsModule\Notifications;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Visiosoft\NotificationsModule\Template\Command\CreateTemplate;


class SubscriptionsModuleNotificationsTemplateSeeder extends Seeder
{
    use DispatchesJobs;

    public function run()
    {
        if (is_module_installed('visiosoft.module.notifications')) {
            $templates = [
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} package has been activated.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Created Subscription',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your Openclassify.com Subscription Has Started!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Created Subscription', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} package has been activated.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Created Subscription(Admin)',
                        'greeting' => 'Hi',
                        'subject' => 'Your Openclassify.com Subscription Has Started!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Created Subscription(Admin)', '_')
                ],
                [
                    'en' => [
                        'message' => '<p>Your subscription has been successfully changed.</p><p>{plan_name}</p>',
                        'name' => 'Subscription Changed',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Subscription Changed | Openclassify.com'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Subscription Changed', '_')
                ],
                [
                    'en' => [
                        'message' => '<tr>
                                     <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                         <table width="100%" cellspacing="0" cellpadding="0">
                                             <tbody>
                                             <tr>
                                                 <td class="esd-container-frame" width="560" valign="top" align="center">
                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                         <tbody>
                                                         <tr>
                                                             <td class="esd-block-text es-m-txt-l es-p15t es-p15b es-m-p15t es-m-p0b es-m-p0r es-m-p0l" align="left">
                                                                 <h2 style="font-size: 26px;"><strong>Unsubscribe</strong></h2>
                                                             </td>
                                                         </tr>
                                                         <tr>
                                                             <td class="esd-block-text es-p20t" align="left">
                                                                 <p style="color: #707070; font-size: 16px;">Hi user,</p>
                                                             </td>
                                                         </tr>
                                                         <tr>
                                                             <td class="esd-block-text es-p15t" align="left">
                                                                 <p style="color: #707070; font-size: 16px;">We are sorry to see you go!&nbsp;<br>Are you sure you wish to unsubscribe from all Openclassify emails?</p>
                                                             </td>
                                                         </tr>
                                                         <tr>
                                                             <td class="esd-block-text es-p20t" align="left">
                                                                 <p style="color: #707070; font-size: 16px;">Lorem Visiosoft<br>Printing and typesetting team</p>
                                                             </td>
                                                         </tr>
                                                         </tbody>
                                                     </table>
                                                 </td>
                                             </tr>
                                             </tbody>
                                         </table>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td class="esd-structure es-p20t es-p40b es-p20r es-p20l" align="left">
                                         <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
                                         <table cellpadding="0" cellspacing="0" class="es-left" align="left">
                                             <tbody>
                                             <tr>
                                                 <td width="270" class="es-m-p20b esd-container-frame" align="left">
                                                     <table cellpadding="0" cellspacing="0" width="100%">
                                                         <tbody>
                                                         <tr>
                                                             <td align="center" class="esd-block-button es-p10"><span class="es-button-border" style="border-bottom-width: 0px; background: #ffb600; border-radius: 4px; display: block;"><a href class="es-button" target="_blank" style="background: #ffb600; border-color: #ffb600; border-radius: 4px; font-size: 16px; border-left-width: 20px; border-right-width: 20px; display: block;">NO</a></span></td>
                                                         </tr>
                                                         </tbody>
                                                     </table>
                                                 </td>
                                             </tr>
                                             </tbody>
                                         </table>
                                         <!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
                                         <table cellpadding="0" cellspacing="0" class="es-right" align="right">
                                             <tbody>
                                             <tr>
                                                 <td width="270" align="left" class="esd-container-frame">
                                                     <table cellpadding="0" cellspacing="0" width="100%">
                                                         <tbody>
                                                         <tr>
                                                             <td align="center" class="esd-block-button es-p10"><span class="es-button-border" style="border-radius: 4px; border-width: 1px; background: #ffffff; border-color: #d1d1d1; display: block;"><a href class="es-button" target="_blank" style="border-radius: 4px; font-size: 16px; background: #ffffff; border-color: #ffffff; color: #d1d1d1; border-left-width: 20px; border-right-width: 20px; display: block;">YES</a></span></td>
                                                         </tr>
                                                         </tbody>
                                                     </table>
                                                 </td>
                                             </tr>
                                             </tbody>
                                         </table>
                                         <!--[if mso]></td></tr></table><![endif]-->
                                     </td>
                                 </tr>',
                        'name' => 'Unsubscribe',
                        'subject' => 'Unsubscribe | Openclassify.com'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Unsubscribe', '_')
                ],
                [
                    'en' => [
                        'message' => '<p>{remaining} days left until your {plan_name} subscription package ends.</p><p>Please purchase a new Subscription or renew your subscription.<br></p><p>If you have placed an automatic payment order, ignore this message.</p><p>Your stores defined in your account: {sites}<br></p><p><a href="https://{provider)}/my-subscriptions">click to pay</a></p>',
                        'name' => 'Subscription Remaining',
                        'greeting' => 'Hi {display_name}',
                        'subject' => '{remaining} days left before your subscription period ends! | Openclassify.com'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Subscription Remaining', '_')
                ],
                [
                    'en' => [
                        'message' => '<p>Your {plan_name} subscription was stopped because no payment was made.</p><p>Your stores defined in your account: {sites}</p><p>Your stores defined above have been stopped.</p>',
                        'name' => 'Subscription Expired',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your {plan_name} subscription has been stopped!| Openclassify.com'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Subscription Expired', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been canceled.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Deleted Subscription',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your openclassify.com {subscription_name} subscription has been canceled.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Deleted Subscription', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription is Activated.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'UnSuspended Subscription',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your openclassify.com {subscription_name} subscription is Activated.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('UnSuspended Subscription', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription is suspended.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Suspended Subscription',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your openclassify.com {subscription_name} subscription is suspended.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Suspended Subscription', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been canceled.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Canceled Subscription For Paddle',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your openclassify.com {subscription_name} subscription has been canceled.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Canceled Subscription For Paddle', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been canceled.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Canceled Subscription For Paddle(Admin)',
                        'greeting' => 'Hi',
                        'subject' => 'Your openclassify.com {subscription_name} subscription has been canceled.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Canceled Subscription For Paddle(Admin)', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been canceled due to no payment.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Failed Payment Subscription For Paddle',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your openclassify.com {subscription_name} subscription has been canceled due to no payment.!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Failed Payment Subscription For Paddle', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been renewed.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Renewed Subscription For Paddle',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your Openclassify.com {subscription_name} subscription has been renewed!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Renewed Subscription For Paddle', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been started.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Created Subscription For Paddle',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your Openclassify.com {subscription_name} subscription has been started!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Created Subscription For Paddle', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} subscription has been started.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Created Subscription For Paddle(Admin)',
                        'greeting' => 'Hi',
                        'subject' => 'Your Openclassify.com {subscription_name} subscription has been started!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Created Subscription For Paddle(Admin)', '_')
                ],
                [
                    'en' => [
                        'message' => '<p>Your {plan_name} subscription was stopped because payment refunded.</p><p>Your stores defined in your account: {sites}</p><p>Your stores defined above have been stopped.</p>',
                        'name' => 'Refunded Payment Subscription For Paddle',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your Openclassify.com {plan_name} subscription has been suspended!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Refunded Payment Subscription For Paddle', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your {url} site is unsuspended!</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'UnSuspended Site For Subscription By Admin',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your {url} site is unsuspended!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('UnSuspended Site For Subscription By Admin', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">this {url} site unsuspend error!</h3><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Error UnSuspend Site For Subscription By Admin',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'this {url} site unsuspend error!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Error UnSuspend Site For Subscription By Admin', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your {url} site is suspended!</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Suspended Site For Subscription By Admin',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your {url} site is suspended!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Suspended Site For Subscription By Admin', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">this {url} site suspend error!</h3><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Error Suspend Site For Subscription By Admin',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'this {url} site suspend error!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Error Suspend Site For Subscription By Admin', '_')
                ],
                [
                    'en' => [
                        'message' => '<h3 class="text-center">Your openclassify.com {subscription_name} package has been activated.</h3><h5 class="text-center">For a more elegant store, visit our Modules and Themes pages.</h5><p class="text-center">Thank You.</p><h6 class="text-center">Openclassify Team</h6>',
                        'name' => 'Created Subscription On Manuel',
                        'greeting' => 'Hi {display_name}',
                        'subject' => 'Your Openclassify.com Subscription Has Started on Manuel!'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => Str::slug('Created Subscription On Manuel', '_')
                ],
                [
                    'en' => [
                        'message' => '<div class="email-body"><table style="width:100%;"><tbody style="width:100%;"><tr><td>{website_address}</td><td style="text-align: right;"><a href="{url}" target="_blank"><button class="action" type="button">OPEN</button></a></td></tr></tbody></table></div><div class="email-body"><table><tbody><tr><td>Username:</td><td>{email}</td></tr><tr><td>Password:</td><td>{password}</td></tr><tr><td>Expiration Date:</td><td>{expiration_date}</td></tr><tr><td colspan="2" style="text-align: center;"><a href="{admin_panel_login}" target="_blank"><button class="action" type="button" style="background: #7361E4 !important; color: #ffffff !important;">Login to Admin Panel</button></a></td></tr></tbody></table></div><style>.action{padding: 5px 15px;border: 1px solid #7361E4 !important;border-radius: 5px !important;outline:none !important;background: #ffffff !important;color: #7361E4 !important;}.action:hover{outline:none !important;background: #7361E4 !important;color: #ffffff!important;}.email-body{margin-bottom:15px;border-radius: 10px;box-shadow: 0 2px 5px #dddddd;padding: 15px;background: #fefefe;}table td, table tr{border: 0 !important;}</style>',
                        'name' => 'Ocify free trial',
                        'greeting' => '{display_name} welcome to ocify',
                        'subject' => 'Ocify account detail'
                    ],
                    'stream' => 'subscriptions',
                    'slug' => 'free_trial_information'
                ]
            ];

            foreach ($templates as $template) {
                $this->dispatchNow(new CreateTemplate($template));
            }
        }
    }
}