<div>

    @switch($type)
        @case('ps')

                @forelse ($record->getSelectedPersonalService() as $cost_type =>
                $personal_service)
                <div>
                    <p>
                        {{ $cost_type }}

                    </p>
                    <div>
                        @foreach ($personal_service as $group_title => $groups)
                        <div>
                            <p>
                                {{ $group_title }}

                            </p>
                            <div>

                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>

                @endforeach
        @break
        @case('mooe')
        @dump($record->getSelectedMOOE())
        @break
        @case('co')
        @dump($record->getSelectedCO())
        @break
        Noone
        @default
    @endswitch


</div>
