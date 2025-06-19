<!-- Copyright (c) Microsoft Corporation.
     Licensed under the MIT License. -->

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    </head>

    <body>
        <main role="main" class="container">
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                <p class="mb-3">{{ session('error') }}</p>
                @if(session('errorDetail'))
                    <pre class="alert-pre border bg-light p-2"><code>{{ session('errorDetail') }}</code></pre>
                @endif
                </div>
            @endif

            <h1>Calendar</h1>
            <h2>{{ $dateRange }}</h2>
            {{-- <a class="btn btn-light btn-sm mb-3" href="{!! route('outlook.getNewEventForm') !!}">New event</a> --}}
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Organizer</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($events)
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->getOrganizer()->getEmailAddress()->getName() }}</td>
                                <td>{{ $event->getSubject() }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->getStart()->getDateTime())->format('n/j/y g:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->getEnd()->getDateTime())->format('n/j/y g:i A') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </main>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>
     