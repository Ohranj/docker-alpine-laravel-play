<!DOCTYPE html>
<html>
    <head>
        <title>ItsolutionStuff.com</title>
    </head>
    <body>
        <h1>{{ $details["title"] }}</h1>
        <p>Hello {{ $details["firstname"] }}</p>
        <p>
            We've received your message and will respond accordingly. We aim to
            get back to you within the next few days
        </p>

        <p>Your message</p>
        <div>
            <q>{{ $details["message"] }}</q>
        </div>
    </body>
</html>
