@extends('layouts.app')
<!-- prettier-ignore -->



@section('main-content')

<h2 class="mb-2 text-2xl mt-10 text-center">Diary</h2>
<p class="mx-auto text-center w-full lg:w-3/4 xl:w-1/2 px-2">
    Your diary allows you to track your workouts. You can write what you like here, using it as a reference point to look back on. By default the page will show you the current month. Feel free however to use the input below to select the date to view past entries or even look ahead and set notes for your future self.
</p>
<div x-data="calendar" class="text-center my-8">
    <form x-ref="setDateForm" method="GET" action="{{route('diary')}}" >
        <input name="date" type="month" class="rounded" @change="$refs.setDateForm.submit()" x-ref="dateInput" value="{{$inputValue}}" />
    </form>
    <div class="grid grid-cols-5 md:grid-cols-7 gap-2 w-full md:w-3/4 xl:w-1/2 mx-auto px-4 lg:px-0 my-4">
        @for ($x = 1; $x <= $days; $x++)
            <x-diary-item :day="$x" :month="$month" :currentMonthDay="$currentMonthDay" />
        @endfor
    </div>
    <x-diary-entry-modal />
</div>



@endsection

@section('scripts')
<script>
    const calendar = () => ({
        showModal: false,
        selectedDay: null,
        currentMonthAndYear: null,
        humanDateString: null,
        init() {
            this.currentMonthAndYear = this.$refs.dateInput.value;
            this.applyWatchers();
        },
        diaryItemPressed(day) {
            this.showModal = true;
            this.selectedDay = day;
            const dateString = `${this.currentMonthAndYear}-${day}`;
            this.humanDateString = new Date(dateString).toLocaleDateString('en-gb', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            })
        },
        closeDiaryItemPressed() {
            console.log('closed')
        },
        applyWatchers() {
            this.$watch('showModal', (active) => {
                if (!active) this.closeDiaryItemPressed()
            })
        }
    })
</script>
@endsection