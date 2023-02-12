<?php

namespace App\Exceptions;

use Exception;

class ViewException extends Exception
{

    /**
     * Page allocated to this exception (rendered with @inertia from resources/js/Pages)
     *
     * @var string
     */
    public string $page = 'EmptyStates/ViewException';

    /**
     * Properties that will be passed to the @inertia page (Component)
     *
     * @var array|string[] $props
     */
    public array $props = [
        'message' => 'An error occurred while trying to load this page.',
        'title' => 'Error',
    ];

    /**
     * ViewException constructor.
     *
     * @param string $message
     * @param string $title
     * @param string $page
     * @param array $props
     */
    public function __construct(string $message = "", string $title = "", string $page = "", array $props = [])
    {
        parent::__construct($message);

        if ($message !== "" && $props !== [])
            $this->props['message'] = $message;
        if ($title !== "" && $props !== [])
            $this->props['title'] = $title;
        if ($page !== "")
            $this->page = $page;
        if ($props !== [])
            $this->props = $props;
    }

}
