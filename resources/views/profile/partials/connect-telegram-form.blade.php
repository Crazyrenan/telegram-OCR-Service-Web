<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Connect Telegram Account
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Connect your Telegram account to receive real-time notifications like purchase request approvals.
        </p>
    </header>

    <div class="mt-6">
        @if(Auth::user()->telegram_chat_id)
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <p class="font-bold">Account Connected!</p>
                <p>Your account is successfully linked to Telegram. You will now receive notifications.</p>
            </div>
        @else
            @if($telegramToken)
                <p class="text-sm text-gray-800">To complete the connection, please copy the following command and send it to your Telegram bot:</p>
                <div class="mt-2 p-3 bg-gray-100 rounded-md">
                    <code class="text-sm text-gray-900">/connect {{ $telegramToken->token }}</code>
                </div>
                <p class="mt-2 text-xs text-gray-500">This code will expire in 10 minutes.</p>
            @else
                <form method="post" action="{{ route('profile.telegram.connect') }}">
                    @csrf
                    <x-primary-button>
                        Generate Connection Command
                    </x-primary-button>
                </form>
            @endif
        @endif
    </div>
</section>
