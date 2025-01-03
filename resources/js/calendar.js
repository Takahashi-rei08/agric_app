import axios from "axios";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

function formatDate(date, pos) {
    const dt = new Date(date);
    if(pos==="end"){
        dt.setDate(dt.getDate() - 1);
    }
    return dt.getFullYear() + '-' +('0' + (dt.getMonth()+1)).slice(-2)+ '-' +  ('0' + dt.getDate()).slice(-2);
}

// カレンダーを表示させたいタグのidを取得
const calendarEls = Array.from(document.querySelectorAll('[id^="calendar"]'));

// 現在の年を取得
const currentYear = new Date().getFullYear(); // 現在の年を取得
const currentMonth = new Date().getMonth(); // 現在の月を取得（0から始まるため注意）

// "calendar"というidがないbladeファイルではエラーが出てしまうので、if文で除外。
if (calendarEls.length>0) {
    let isSyncing = false; // 同期中かどうかを判定するフラグ
    
    const calendars = []; // calendarsを初期化
    console.log(1);
    calendarEls.forEach((calendarEl, index) => {
        if(!calendarEl) return;
        const yearToShow = currentYear - index;
        
        const calendar = new Calendar(calendarEl, {
            // プラグインの導入
            plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin],
        
            // カレンダー表示
                initialView: "dayGridMonth", // 最初に月で表示させる
                initialDate: `${yearToShow}-${('0' + (currentMonth+1)).slice(-2)}-01`, // それぞれのカレンダーで表示する年を設定
            
            customButtons: { 
                eventAddButton: { // 新規予定追加ボタン
                    text: '予定を追加',
                    click: function() {
                        // 初期化
                        document.getElementById("new-id").value = "";
                        document.getElementById("new-event_title").value = "";
                        document.getElementById("new-start_date").value = "";
                        document.getElementById("new-end_date").value = "";
                        document.getElementById("new-event_body").value = "";
                        document.getElementById("new-event_color").value = "blue";
        
                        // 新規予定追加モーダルを開く
                        document.getElementById('modal-add').style.display = 'flex';
                    }
                }
            },
            
            

            
            headerToolbar: { // ヘッダーの設定
                start: index === 0 ? "prevYear,prev,next,nextYear today" : '', // ヘッダー左（前年、前月、次月、翌年、今日の順番で左から配置）
                center: "title", // ヘッダー中央（今表示している(月、)年）
                end: index === 0 ? "eventAddButton dayGridMonth,dayGridWeek" : '', // ヘッダー右（予定追加、月形式、時間形式）
            },
            
            // ヘッダー操作による同期処理
            datesSet: function() {
                if(isSyncing) return; // すでに同期中の場合は処理をスキップ
                isSyncing = true; // 同期開始
                
                console.log(isSyncing);
                const currentData = calendars[0].getCurrentData(); // 基準カレンダーのデータ取得
                const baseDate = new Date(currentData.currentDate); // 基準日を取得
                baseDate.setHours(0, 0, 0, 0); // 午前0時に設定
                
                if (currentData && currentData.viewApi) {  // currentDataとviewApiの存在確認
                    const currentView = currentData.viewApi.type;
                    calendars.forEach((cal, calIndex) => {
                        console.log('cal:',cal);
                        if (calIndex !== 0) { // 基準カレンダーはスキップ
                            const targetDate = new Date(baseDate); // 基準日をコピー
                            targetDate.setFullYear(targetDate.getFullYear() - calIndex); // calIndex年前に設定
                            targetDate.setDate(baseDate.getDate()); // 基準日の日付を使う
                            
                            // 変更が必要か確認
                            const currentCalendarData = cal.getCurrentData();
                            if (currentCalendarData.currentDate.getFullYear() !== targetDate.getFullYear() || // 年を比較
                                currentCalendarData.currentDate.getMonth() !== targetDate.getMonth() || // 月を比較
                                currentCalendarData.currentDate.getDate() !== targetDate.getDate() || // 日を比較
                                currentCalendarData.viewApi.type !== currentView) { // ビューを比較
                                cal.changeView(currentView); // 同じビューに切り替え
                                cal.gotoDate(targetDate); // 日付も同期
                            }
                        }
                    });
                } else {
                    console.error("currentData または view が見つかりません。");
                }
                isSyncing = false; // 同期完了
                console.log(isSyncing);
            },
            
            height: "auto", // 高さをウィンドウサイズに揃える
            
            // カレンダーで日程を指定して新規予定追加
            selectable: true, // 日程の選択を可能にする
            select: function (info) { // 日程を選択した後に行う処理を記述
                // 選択した日程を反映（のこりは初期化）
                document.getElementById("new-id").value = "";
                document.getElementById("new-event_title").value = "";
                document.getElementById("new-start_date").value = formatDate(info.start); // 選択した開始日を反映
                document.getElementById("new-end_date").value = formatDate(info.end, "end"); // 選択した終了日を反映
                document.getElementById("new-event_body").value = "";
                document.getElementById("new-event_color").value = "blue";
                document.getElementById("select_action").value = "";
                document.getElementById("select_plant").value = "";
                document.getElementById("select_plant_variety").value = "";
                
                // 新規予定追加モーダルを開く
                document.getElementById('modal-add').style.display = 'flex';
            },
            
            
            // DBに登録した予定を表示する
            events: function (info, successCallback, failureCallback) { // eventsはページが切り替わるたびに実行される
                // 現在カレンダーが表示している日付の期間を設定
                const startDate = info.start.valueOf();
                const endDate = info.end.valueOf();
                
                // 並行してリクエストを実行
                Promise.all([
                    // axiosでLaravelの予定取得処理を呼び出す
                    axios.post("/calendar/get_schedule", {
                        start_date: startDate,
                        end_date: endDate,
                    }),
                    axios.post("/calendar/get_post", {
                        start_date: startDate,
                        end_date: endDate,
                    })
                ])
                
                .then((responses) => {
                    console.log(3);
                    const scheduleResponse = responses[0].data;
                    const postResponse = responses[1].data;
                    
                    // 既に表示されているイベントを削除（重複防止）
                    calendar.removeAllEvents();
                    
                    // postかscheduleか判断するプロパティを入れる
                    const judgedScheduleResponse = scheduleResponse.map(item => ({
                        ...item,
                        isSchedule: true // scheduleならtrue
                    }));
                    const judgedPostResponse = postResponse.map(item => ({
                        ...item,
                        isSchedule: false // postならfalse
                    }));
                    
                    // まとめたイベントを一つの配列にまとめる
                    const allEvents = [...judgedScheduleResponse, ...judgedPostResponse];
                    
                    // カレンダーに読み込み
                    successCallback(allEvents); // successCallbackに予定をオブジェクト型で入れるとカレンダーに表示できる
                })
                .catch((error) => {
                    console.error(error); // エラー内容をコンソールに表示
                    // バリデーションエラーなど
                    alert("登録に失敗しました。");
                    failureCallback();
                });
            },
            
            // 予定をクリックすると予定編集モーダルが表示される
            eventClick: function(info) {
                // scheduleなら編集モーダルを表示
                if(info.event.isSchedule){
                    //console.log(info.event); // info.event内に予定の全情報が入っているので、必要に応じて参照すること
                    document.getElementById("id").value = info.event.id;
                    document.getElementById("delete-id").value = info.event.id;
                    document.getElementById("event_title").value = info.event.title;
                    document.getElementById("start_date").value = formatDate(info.event.start);
                    document.getElementById("end_date").value = formatDate(info.event.end, "end");
                    document.getElementById("event_body").value = info.event.extendedProps.description;
                    document.getElementById("event_color").value = info.event.backgroundColor;
                    
                    let jsonSceduleDatas = document.getElementById("schedule_datas").getAttribute('value'); //value値の取得
                    const scheduleDatas = JSON.parse(jsonSceduleDatas.replace(/&quot;/g, '"')); //JSONを連想配列に変換
                    let eventId = Number(info.event.id) - 1; //indexを合わせる
                    //actionの選択
                    let selectedAction = scheduleDatas[eventId]['action_id']; //元のindex
                    const selectAction = document.getElementById("select_action2");
                    if (selectedAction !== null && selectedAction !== undefined) { //nullを除外
                        const actionIndex = Number(selectedAction);
                        for(let i = 0; i < selectAction.options.length; i++){ //select要素内のoptionをループ
                            console.log(selectAction.options[i].value, ';', actionIndex)
                            if(Number(selectAction.options[i].value) === actionIndex){
                                selectAction.options[i].selected = true; //マッチしたindexを選択
                                break; //ループを抜ける
                            }
                        }
                    } else {
                        selectAction.options[0].selected = true;
                    }
                    //plantの選択
                    let selectedPlant = scheduleDatas[eventId]['plant_id'];
                    const selectPlant = document.getElementById("select_plant2");
                    if(selectedPlant !== null && selectedPlant !== undefined){ //nullを除外
                        const plantIndex = Number(selectedPlant);
                        for(let i = 0; i < selectPlant.options.length; i++){ //select要素内のoptionをループ
                            if(Number(selectPlant.options[i].value) === plantIndex){
                                selectPlant.options[i].selected = true; //マッチしたindexを選択
                                // 品種の選択肢の追加
                                const select_plant_variety = document.getElementById("select_plant_variety2");
                                //元のoptionを全て消す
                                while(select_plant_variety.lastElementChild){
                                    select_plant_variety.removeChild(select_plant_variety.lastChild);
                                }
                                var option = document.createElement("option");
                                option.text = "品種を選択";
                                option.value = '';
                                select_plant_variety.appendChild(option); //optionを追加
                                var select_plant  = document.getElementById("select_plant2");
                                let jsonPlantVarietyDatas = document.getElementById("plantVarieties_datas").getAttribute('value'); //value値の取得
                                const plantVarietyDatas = JSON.parse(jsonPlantVarietyDatas.replace(/&quot;/g, '"')); //JSONを連想配列に変換
                                for(let i = 0; i < plantVarietyDatas.length; ++i){ //select要素内のoptionをループ
                                    if(plantVarietyDatas[i]["plant_id"] == select_plant.value){
                                        var option = document.createElement("option");
                                        option.value = plantVarietyDatas[i]["id"];
                                        option.text = plantVarietyDatas[i]["name"];
                                        select_plant_variety.appendChild(option);
                                    }
                                }
                                break;
                            }
                        }
                    } else {
                        selectPlant.options[0].selected = true; //マッチしたindexを選択
                    }
                    let selectedPlantVariety = scheduleDatas[eventId]['plantVariety_id'];
                    const selectPlantVariety = document.getElementById("select_plant_variety2");
                    if(selectedPlantVariety !== null && selectedPlantVariety !== undefined){ //nullを除外
                        const plantVarietyIndex = Number(selectedPlantVariety);
                        for(let i = 0; i < selectPlantVariety.options.length; i++){ //select要素内のoptionをループ
                            if(Number(selectPlantVariety.options[i].value) === plantVarietyIndex){
                                selectPlantVariety.options[i].selected = true;
                                break;
                            }
                        }
                    } else {
                        selectPlantVariety.options[0].selected = true;
                    }
            
                    // 予定編集モーダルを開く
                    document.getElementById('modal-update').style.display = 'flex';
                }
                // postなら詳細のページに飛ぶ
                else{
                    window.location.href = `../post/${info.event.id}`
                }
            },
        });
        
        calendars.push(calendar); // calendarsにカレンダーを追加
        calendar.render(); // 各カレンダーのレンダリング
        console.log(4);
    });
    
    // ブラウザのリサイズ時にカレンダーをリフレッシュ
    window.addEventListener('resize', () => {
        calendars.forEach(calendar => calendar.updateSize());
    });
    
    // 新規予定追加モーダルを閉じる
    window.closeAddModal = function(){
        document.getElementById('modal-add').style.display = 'none';
    }
    
    // 予定編集モーダルを閉じる
    window.closeUpdateModal = function(){
        document.getElementById('modal-update').style.display = 'none';
    }
    
    window.deleteEvent = function(){
        'use strict'
    
        if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('delete-form').submit();
        }
    }
}