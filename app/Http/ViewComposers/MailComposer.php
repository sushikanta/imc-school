<?php

namespace App\Http\ViewComposers;

use App\MailToken;
use App\Models\ContactusQuery;
use App\User;
use Illuminate\View\View;

class MailComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    private $frontend_url;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */

    public function __construct()
    {

        $this->frontend_url = env('FRONTEND_URL', 'http://dev.time2staff.com');
        // Dependencies automatically resolved by service container...

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //-- getting default mail params
       // $this->getDefaultMailParams($view);

        $data =  $view->getData();

        if(@$data['type'] == MailToken::TYPE_MAIL_CONFIRMATION){
            $this->getMailConfirmationParams($view);
        }else if(@$data['type'] == MailToken::TYPE_FORGOT_PASSWORD){
            $this->getForgotPasswordParams($view);
        }else if(@$data['type'] == MailToken::TYPE_MAIL_CONTACTUS){
            $this->getContactUsParams($view);
        }

    }

    public function getDefaultMailParams($view){
        $logo_header = $this->frontend_url.'/001/resources/mailer_logo.png';
        $logo_footer = $this->frontend_url.'/001/resources/logo_square.png';
        $img_blank = $this->frontend_url.'/001/resources/blank.gif';
        $link_site_url = $this->frontend_url;
        $link_contact = $this->frontend_url.'/contact';

        $defaults = compact(
            'logo_footer',
            'logo_header',
            'img_blank',
            'link_site_url',
            'link_contact'
        );
        $view->with($defaults);
    }

    public function getMailConfirmationParams($view)
    {
        $data =  $view->getData();
        $user_id = $data['user_id'];
        $options = ['user_id' => $user_id];
        $token = MailToken::getMailToken($user_id, MailToken::TYPE_MAIL_CONFIRMATION, $options);

        $link_confirmation = $this->frontend_url.'/mails/confirm/'.$token;
        $link_view_in_browser = $this->frontend_url.'/mails/preview/'.$token;
        $view->with([
            'link_confirmation' => $link_confirmation,
            'link_view_in_browser' => $link_view_in_browser
        ]);
    }

    public function getForgotPasswordParams($view)
    {
        $data =  $view->getData();
        $user_id = $data['user_id'];
        $options = ['user_id' => $user_id];
        $token = MailToken::getMailToken($user_id, MailToken::TYPE_FORGOT_PASSWORD, $options);
        $user = User::find($user_id);

        $link_reset_password = $this->frontend_url.'/reset-password/'.$token;
        $link_view_in_browser = $this->frontend_url.'/mails/preview/'.$token;
        $view->with([
            'firstname' => $user->firstname,
            'link_reset_password' => $link_reset_password,
            'link_view_in_browser' => $link_view_in_browser
        ]);
    }

    public function getContactUsParams($view)
    {
        $data =  $view->getData();
        $id = $data['id'];
        $obj = ContactusQuery::find($id);
        $view->with(compact('obj'));
    }
}