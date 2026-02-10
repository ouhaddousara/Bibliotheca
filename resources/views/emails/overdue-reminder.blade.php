@component('mail::message')
# 📧 Petit rappel amical...

Bonjour **{{ $member->firstname }}**,

Nous espérons que vous avez apprécié votre lecture de **{{ $book->title }}** ! 📖

Malheureusement, ce livre est en retard de **{{ $daysLate }} jour(s)**.  
📅 Date de retour prévue : **{{ $loan->due_date->format('d/m/Y') }}**

@component('mail::panel')
⚠️ **Action requise**  
Merci de rapporter cet exemplaire dès que possible à la bibliothèque.  
📍 *Horaires : Lundi-Vendredi 9h-18h, Samedi 10h-16h*
@endcomponent

@if($daysLate > 7)
❗ *Un retard prolongé peut entraîner la suspension temporaire de votre compte.*
@endif

@include('emails.signature', ['text' => $signature])

@component('mail::button', ['url' => route('client.loans.index', absolute: true)])
Voir mes emprunts
@endcomponent

Merci pour votre compréhension et votre coopération ! 
L'équipe de la bibliothèque 
@endcomponent