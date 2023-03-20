<?php namespace Visiosoft\ContactPlugin\Form;

use Visiosoft\ContactPlugin\Form\Command\BuildMessage;
use Visiosoft\ContactPlugin\Form\Command\GetMessageData;
use Visiosoft\ContactPlugin\Form\Command\GetMessageView;
use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

/**
 * Class ContactFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class ContactFormHandler
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param ContactFormBuilder $builder
     * @param MessageBag         $messages
     * @param Mailer             $mailer
     */
    public function handle(ContactFormBuilder $builder, MessageBag $messages, Mailer $mailer)
    {
        // Validation failed!
        if ($builder->hasFormErrors()) {
            return;
        }

        // Delegate these for now.
        $view = $this->dispatch(new GetMessageView($builder));
        $data = $this->dispatch(new GetMessageData($builder));

        // Build the message object.
        $message = function (Message $message) use ($builder) {
            $this->dispatch(new BuildMessage($message, $builder));
        };

        // Send the email.
        $mailer->send($view, $data, $message);

        // If there are any failures, report.
        if(count($mailer->failures()) > 0) {
            $messages->error(
                $builder->getFormOption('error_message', 'visiosoft.plugin.contact::error.send_message')
            );
        } else {
            // Otherwise, show success.
            $messages->success(
                $builder->getFormOption('success_message', 'visiosoft.plugin.contact::success.send_message')
            );
        }

        // Clear the form!
        $builder->resetForm();
    }
}
