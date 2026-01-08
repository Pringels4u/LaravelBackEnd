<div style="font-family: sans-serif; line-height: 1.4; color: #111">
    <h2>Nieuw contactbericht</h2>

    <p><strong>Van:</strong> {{ $contact->name }} &lt;{{ $contact->email }}&gt;</p>
    @if($contact->subject)
        <p><strong>Onderwerp:</strong> {{ $contact->subject }}</p>
    @endif

    <hr />

    <div style="white-space: pre-wrap">{{ $contact->message }}</div>

    <p style="color: #888; font-size: 12px; margin-top: 1rem;">Bericht ID: {{ $contact->id }} | {{ $contact->created_at }}</p>
</div>
