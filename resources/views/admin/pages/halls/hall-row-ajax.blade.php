<li class="admin-halls__row">
    <p class="admin-halls__row-number">{{ $numberRow }}</p>

    <ul class="admin-halls__row-icons">
        @for($i = 1; $i <= $countSeats; $i++)
            <li class="admin-halls__row-icon">
                <svg x="915" y="700" width="80" height="86" class="sc-idjmjb kXPQqn" type="recliner">
                    <g transform="rotate(0, 40, 43)" class="sc-fHlXLc bXVYGC" height="86" width="80">
                        <svg width="100%" height="100%" fill="currentColor" id="Слой_1" data-name="Слой 1"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 69 90">
                            <defs>
                                <style></style>
                            </defs>
                            <path class="cls-1"
                                  d="M18.38,46.15V71.06H55.85V46.15a7.83,7.83,0,0,1,7.82-7.82V33.26A9.67,9.67,0,0,0,61,26.53a8.37,8.37,0,0,1-4.37,1.24H23.42v1a7.65,7.65,0,0,1-7.64,7.64H10.55v1.89h0A7.83,7.83,0,0,1,18.38,46.15Z"></path>
                            <path class="cls-1"
                                  d="M23.42,18.34v5.23H54a9.67,9.67,0,0,1,4.81,1.27,5.83,5.83,0,0,0,3.64-5.4v-11a5.85,5.85,0,0,0-5.84-5.84H17.64A5.85,5.85,0,0,0,11.8,8.46v2.23h4A7.65,7.65,0,0,1,23.42,18.34Z"></path>
                            <path class="cls-1"
                                  d="M23.42,23.57v1.7H56.58a5.75,5.75,0,0,0,2.2-.43A9.67,9.67,0,0,0,54,23.57Z"></path>
                            <path class="cls-1"
                                  d="M5.22,46.15V78.88a5.33,5.33,0,0,0,5.33,5.33H63.67A5.33,5.33,0,0,0,69,78.88V46.15a5.33,5.33,0,0,0-5.33-5.32h0V65.77a9.7,9.7,0,0,1-9.7,9.7H20.25a9.7,9.7,0,0,1-9.7-9.7V40.83A5.33,5.33,0,0,0,5.22,46.15Z"></path>
                            <path class="cls-1"
                                  d="M20.25,75.47H54a9.7,9.7,0,0,0,9.7-9.7V40.83a5.33,5.33,0,0,0-5.32,5.32V73.56H15.88V46.15a5.33,5.33,0,0,0-5.33-5.32h0V65.77A9.7,9.7,0,0,0,20.25,75.47Z"></path>
                            <path class="cls-1"
                                  d="M13.28,26.53a8.34,8.34,0,0,1-4-7.09V13.19h-4A5.15,5.15,0,0,0,.18,18.34V28.8a5.14,5.14,0,0,0,5.14,5.14h5.23v-.68A9.64,9.64,0,0,1,13.28,26.53Z"></path>
                            <path class="cls-1"
                                  d="M13.28,26.53a9.64,9.64,0,0,0-2.73,6.73v.68h5.23a5.14,5.14,0,0,0,5.14-5.14v-1H17.64A8.3,8.3,0,0,1,13.28,26.53Z"></path>
                            <path class="cls-1"
                                  d="M15.45,24.84a9.61,9.61,0,0,1,4.8-1.27h.67V18.34a5.15,5.15,0,0,0-5.14-5.15h-4v6.25A5.83,5.83,0,0,0,15.45,24.84Z"></path>
                            <path class="cls-1"
                                  d="M20.25,23.57a9.61,9.61,0,0,0-4.8,1.27,5.66,5.66,0,0,0,2.19.43h3.28v-1.7Z"></path>
                            <path class="cls-1"
                                  d="M13.28,26.53a9.91,9.91,0,0,1,1-.87,7.09,7.09,0,0,1-3.69-6.22V13.19H9.3v6.25A8.34,8.34,0,0,0,13.28,26.53Z"></path>
                            <path class="cls-1"
                                  d="M14.24,25.66a9.91,9.91,0,0,0-1,.87,8.3,8.3,0,0,0,4.36,1.24h3.28V26.52H17.64A7.09,7.09,0,0,1,14.24,25.66Z"></path>
                            <path class="cls-1"
                                  d="M14.24,25.66a10.27,10.27,0,0,1,1.21-.82,5.83,5.83,0,0,1-3.65-5.4V13.19H10.55v6.25A7.09,7.09,0,0,0,14.24,25.66Z"></path>
                            <path class="cls-1"
                                  d="M17.64,25.27a5.66,5.66,0,0,1-2.19-.43,10.27,10.27,0,0,0-1.21.82,7.09,7.09,0,0,0,3.4.86h3.28V25.27Z"></path>
                        </svg>
                        <text text-anchor="middle" x="22" y="30" fill="#565859" stroke="none"
                              font-family="Ubuntu, Roboto, Arial, Helvetica, sans-serif" font-size="40.95238095238095"
                              font-weight="400"
                              class="sc-iKpIOp dkYnCx">
                            {{ $i }}
                        </text>
                    </g>
                </svg>
            </li>
            <input type="hidden" name="rows[{{$numberRow}}][{{$i}}][seatNumber]" value="{{$i}}">
            <input type="hidden" name="rows[{{$numberRow}}][{{$i}}][seatsTypeId]" value="{{$seatTypeId}}">
        @endfor
    </ul>

    <p class="admin-halls__row-number">{{ $numberRow }}</p>
</li>
