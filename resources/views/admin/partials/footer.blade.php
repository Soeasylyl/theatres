<footer>
    <div class="modal" id="blockModal">
        <div class="modal__container">
            <div class="modal__title">{{ __('ЗАБЛОКИРОВАТЬ ДО:') }}</div>

            <form method="POST" action="{{ route('user.block') }}">
                @csrf
                @method('PUT')

                <input name="userId" id="userBlockId" type="hidden">
                <input type="datetime-local" name="dateTime" required/>

                <div class="modal__button-wrapper">
                    <button type="submit" class="modal__button modal__block-btn">{{ __('Заблокировать') }}</button>
                    <div class="modal__button modal__close-btn">{{ __('Отмена') }}</div>
                </div>
            </form>
        </div>
    </div>
</footer>
