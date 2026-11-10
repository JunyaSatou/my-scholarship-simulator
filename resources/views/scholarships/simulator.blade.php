<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="奨学金の毎月の返済額と繰上返済による返済額の変化を試算できます。">
    <title>奨学金返済シミュレーター</title>
    <style>
        :root{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Noto Sans JP",Meiryo,sans-serif;color:#1e3029;background:#f4f5ef;font-synthesis:none;font-optical-sizing:auto}*{box-sizing:border-box}body{margin:0}.shell{max-width:1120px;margin:0 auto;padding:38px 24px 72px}.topline{display:flex;justify-content:space-between;align-items:center;margin-bottom:36px;color:#60746b;font-size:13px;letter-spacing:.08em}.brand{font-weight:750;color:#234637;letter-spacing:.02em}.hero{max-width:760px;margin-bottom:30px}.eyebrow{margin:0 0 12px;color:#65816d;font-size:12px;font-weight:700;letter-spacing:.16em;text-transform:uppercase}h1{margin:0;font-size:clamp(30px,5vw,48px);letter-spacing:-.045em;line-height:1.2}.lead{margin:16px 0 0;color:#63726b;line-height:1.8}.layout{display:grid;grid-template-columns:350px minmax(0,1fr);gap:22px;align-items:start}.card{background:#fff;border:1px solid #e2e8df;border-radius:18px;box-shadow:0 8px 26px rgba(36,65,49,.045)}.form-card{padding:24px;position:sticky;top:18px}.section-title{font-size:16px;margin:0 0 20px}.field{margin:0 0 17px}.field label,.field-label{display:block;font-size:13px;font-weight:700;margin-bottom:7px}.input-wrap{position:relative}.field input{display:block;width:100%;height:46px;border:1px solid #d8e0d8;border-radius:10px;background:#fbfcf9;padding:0 48px 0 13px;color:#20372c;font:inherit;font-size:15px;outline:none}.field input:focus{border-color:#4d8464;box-shadow:0 0 0 3px rgba(77,132,100,.12)}.suffix{position:absolute;right:13px;top:50%;transform:translateY(-50%);color:#819087;font-size:13px;pointer-events:none}.help{margin:6px 0 0;color:#839087;font-size:11px;line-height:1.6}.error{color:#a33e36;font-size:12px;margin:6px 0 0}.divider{border:0;border-top:1px solid #edf0eb;margin:22px 0}.early-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}.early-head .field-label{margin:0}.text-button{border:0;background:none;color:#34704f;font:inherit;font-size:12px;font-weight:700;cursor:pointer;padding:6px}.early-help{font-size:11px;color:#7a8980;line-height:1.6;margin:0 0 12px}.early-row{position:relative;display:grid;grid-template-columns:1fr 1.15fr;gap:8px;padding:11px 30px 10px 10px;border:1px solid #e8ede6;border-radius:12px;margin-bottom:9px}.early-row .field{margin:0}.early-row .field input{height:40px;padding-left:10px;font-size:13px}.early-row .suffix{font-size:11px;right:9px}.remove-row{position:absolute;right:6px;top:5px;border:0;background:transparent;color:#9b625d;font-size:18px;cursor:pointer}.submit{width:100%;height:49px;border:0;border-radius:11px;background:#275b41;color:white;font:inherit;font-size:14px;font-weight:750;cursor:pointer;transition:background .15s,transform .15s}.submit:hover{background:#1c4933;transform:translateY(-1px)}.note{margin:12px 0 0;color:#839087;font-size:10px;line-height:1.6}.result-column{min-width:0}.alert{padding:14px 16px;border-radius:12px;background:#fff1ef;border:1px solid #f1d1cc;color:#963f37;font-size:13px;margin-bottom:16px}.summary{padding:23px 24px 24px;margin-bottom:16px}.result-heading{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px}.result-heading h2{font-size:17px;margin:0}.badge{background:#eaf3ec;color:#34704f;padding:6px 10px;border-radius:999px;font-size:11px;font-weight:700;white-space:nowrap}.metrics{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}.metric{padding:15px 14px;border:1px solid #e8ede6;border-radius:13px;background:#fcfdfa;min-width:0}.metric-label{font-size:11px;color:#7a8980;margin-bottom:8px}.metric-value{font-size:clamp(17px,2.6vw,25px);font-weight:760;letter-spacing:-.035em;white-space:nowrap}.metric-value small{font-size:12px;font-weight:500;letter-spacing:0;margin-left:2px}.metric.accent{background:#eff6ef;border-color:#dce9dc}.metric.accent .metric-value{color:#2d704c}.meta{display:flex;gap:16px;flex-wrap:wrap;margin-top:15px;color:#76857c;font-size:11px}.table-card{overflow:hidden}.table-head{padding:19px 22px;border-bottom:1px solid #edf0eb;display:flex;justify-content:space-between;align-items:baseline;gap:12px}.table-head h2{margin:0;font-size:16px}.table-head span{font-size:11px;color:#89958e}.table-scroll{overflow:auto;max-height:620px}table{width:100%;min-width:880px;border-collapse:collapse;font-size:12px}thead{position:sticky;top:0;background:#f7f9f5;z-index:1}th,td{padding:11px 12px;text-align:right;border-bottom:1px solid #eef1ec;white-space:nowrap}th{font-size:10px;color:#738178;font-weight:700}th:nth-child(3),td:nth-child(3){text-align:left}td{font-variant-numeric:tabular-nums}.early-payment td{background:#f1f7ef}.early-tag{display:inline-block;margin-left:6px;background:#dcebd9;color:#36724d;padding:3px 6px;border-radius:5px;font-size:9px;font-weight:700}.empty{display:grid;min-height:400px;place-items:center;text-align:center;color:#87958c;padding:36px}.empty-icon{width:54px;height:54px;border-radius:17px;background:#e9f0e7;color:#4c795b;display:grid;place-items:center;font-size:25px;margin:0 auto 15px}.empty strong{display:block;color:#455e50;font-size:14px;margin-bottom:7px}.empty p{font-size:12px;line-height:1.8;margin:0}.footnote{margin:16px 4px 0;color:#89958e;font-size:10px;line-height:1.8}.placeholder{border:1px dashed #dce5dc;border-radius:10px;padding:13px;color:#8a978f;font-size:11px;line-height:1.6}
        @media(max-width:850px){.layout{grid-template-columns:1fr}.form-card{position:static}.form-card{max-width:none}.empty{min-height:260px}}
        @media(max-width:540px){.shell{padding:22px 14px 48px}.topline{margin-bottom:28px}.form-card,.summary{padding:19px}.metrics{grid-template-columns:1fr 1fr}.metric:last-child{grid-column:1/-1}.metric-value{font-size:21px}.result-heading{align-items:flex-start;flex-direction:column}.table-head{padding:16px}}
    </style>
</head>
<body>
<main class="shell">
    <div class="topline"><span class="brand">MY SCHOLARSHIP</span><span>返済計画を、見える化。</span></div>
    <header class="hero">
        <p class="eyebrow">Repayment planner</p>
        <h1>奨学金返済<br>シミュレーター</h1>
        <p class="lead">貸与総額と年利から毎月の返済計画を試算します。繰上返済を加えると、返済総額や返済回数がどう変わるか確認できます。</p>
    </header>

    <div class="layout">
        <section class="card form-card" aria-labelledby="form-title">
            <h2 class="section-title" id="form-title">条件を入力</h2>
            <form method="post" action="{{ route('scholarships.simulate') }}" id="simulator-form">
                @csrf
                <div class="field">
                    <label for="principal">奨学金の返済総額</label>
                    <div class="input-wrap"><input id="principal" name="principal" type="number" min="30000" max="100000000" step="10000" value="{{ old('principal', $result['principal'] ?? 3840000) }}" required><span class="suffix">円</span></div>
                    @error('principal')<p class="error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="annual_rate">年利</label>
                    <div class="input-wrap"><input id="annual_rate" name="annual_rate" type="number" min="0" step="0.01" value="{{ old('annual_rate', $result['annual_rate'] ?? '0.16') }}" required><span class="suffix">％</span></div>
                    <p class="help">無利子の場合は 0 を入力してください。</p>
                    @error('annual_rate')<p class="error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="lending_end_month">奨学金の貸与終了年月</label>
                    <div class="input-wrap"><input id="lending_end_month" name="lending_end_month" type="month" value="{{ old('lending_end_month', $result['lending_end_month'] ?? date('Y').'-03') }}" required></div>
                    <p class="help">貸与終了月の7か月後を初回返済月として計算します（3月終了の場合は10月開始）。</p>
                    @error('lending_end_month')<p class="error">{{ $message }}</p>@enderror
                </div>

                <hr class="divider">
                <div class="early-head"><span class="field-label">繰上返済（任意）</span><button type="button" class="text-button" id="add-early">＋ 追加</button></div>
                <p class="early-help">繰上返済する年月と予算額を追加できます。複数回は予定順に入力してください。</p>
                <div id="early-rows">
                    @php($submittedEarlyRepayments = old('early_repayments', $earlyRepayments ?? []))
                    @foreach($submittedEarlyRepayments as $index => $earlyRepayment)
                        <div class="early-row">
                            <button type="button" class="remove-row" aria-label="繰上返済を削除">×</button>
                            <div class="field"><label>返済年月</label><div class="input-wrap"><input type="month" name="early_repayments[{{ $index }}][date]" value="{{ $earlyRepayment['date'] ?? '' }}" required></div></div>
                            <div class="field"><label>予算額</label><div class="input-wrap"><input type="number" name="early_repayments[{{ $index }}][amount]" min="1" value="{{ $earlyRepayment['amount'] ?? '' }}" required><span class="suffix">円</span></div></div>
                        </div>
                    @endforeach
                </div>
                @error('early_repayments.*.date')<p class="error">{{ $message }}</p>@enderror
                @error('early_repayments.*.amount')<p class="error">{{ $message }}</p>@enderror
                @error('simulation')<p class="error">{{ $message }}</p>@enderror

                <button type="submit" class="submit">返済計画を計算する <span aria-hidden="true">→</span></button>
                <p class="note">試算結果は入力条件に基づく概算です。実際の返還額・日程は貸与元の案内をご確認ください。</p>
            </form>
        </section>

        <section class="result-column" aria-live="polite">
            @if(isset($result))
                <section class="card summary">
                    <div class="result-heading"><h2>シミュレーション結果</h2><span class="badge">{{ $result['early_payment_count'] > 0 ? '繰上返済あり' : '通常返済' }}</span></div>
                    <div class="metrics">
                        <div class="metric"><div class="metric-label">毎月の返済額（目安）</div><div class="metric-value">{{ number_format($result['monthly_payment']) }}<small>円</small></div></div>
                        <div class="metric"><div class="metric-label">返済総額</div><div class="metric-value">{{ number_format($result['total_paid']) }}<small>円</small></div></div>
                        <div class="metric accent"><div class="metric-label">繰上返済による差額</div><div class="metric-value">{{ number_format($result['savings']) }}<small>円</small></div></div>
                    </div>
                    <div class="meta"><span>返済期間：{{ $result['repayment_years'] }}年（最大{{ $result['installments'] }}回）</span><span>年利：{{ rtrim(rtrim(number_format($result['annual_rate'], 2), '0'), '.') }}％</span><span>貸与総額：{{ number_format($result['principal']) }}円</span></div>
                </section>
                <section class="card table-card">
                    <div class="table-head"><h2>返済計画表</h2><span>{{ count($result['schedule']) }}回分の返済</span></div>
                    <div class="table-scroll"><table>
                        <thead><tr><th>残り回数</th><th>返済前残額</th><th>引落日</th><th>返済額</th><th>元金</th><th>据置利息</th><th>利息</th><th>端数調整</th><th>返済後残額</th></tr></thead>
                        <tbody>
                        @foreach($result['schedule'] as $row)
                            <tr @class(['early-payment' => $row['early']])>
                                <td>{{ number_format($row['remaining_count']) }}回</td><td>{{ number_format($row['balance']) }}円</td>
                                <td>{{ $row['date'] }}@if($row['early'])<span class="early-tag">繰上返済</span>@endif</td>
                                <td><strong>{{ number_format($row['amount']) }}円</strong></td><td>{{ number_format($row['principal']) }}円</td>
                                <td>{{ number_format($row['deferred_interest']) }}円</td><td>{{ number_format($row['interest']) }}円</td>
                                <td>{{ number_format($row['remainder']) }}円</td><td>{{ number_format($row['balance_after']) }}円</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table></div>
                </section>
                <p class="footnote">引落日は毎月27日を基準とし、土日の場合は翌営業日に調整しています。繰上返済後の予定日は前倒しで表示しています。</p>
            @else
                <section class="card empty"><div><div class="empty-icon" aria-hidden="true">↗</div><strong>返済計画をここに表示します</strong><p>左のフォームに条件を入力して<br>「返済計画を計算する」を押してください。</p></div></section>
            @endif
        </section>
    </div>
</main>
<template id="early-row-template">
    <div class="early-row">
        <button type="button" class="remove-row" aria-label="繰上返済を削除">×</button>
        <div class="field"><label>返済年月</label><div class="input-wrap"><input type="month" data-name="date" required></div></div>
        <div class="field"><label>予算額</label><div class="input-wrap"><input type="number" data-name="amount" min="1" required><span class="suffix">円</span></div></div>
    </div>
</template>
<script>
(() => {
    const rows = document.getElementById('early-rows');
    const template = document.getElementById('early-row-template');
    const addButton = document.getElementById('add-early');
    const addRow = (values = {}) => {
        const index = rows.querySelectorAll('.early-row').length;
        const fragment = template.content.cloneNode(true);
        fragment.querySelectorAll('[data-name]').forEach((input) => {
            input.name = `early_repayments[${index}][${input.dataset.name}]`;
            input.value = values[input.dataset.name] ?? '';
        });
        rows.append(fragment);
    };
    addButton.addEventListener('click', () => addRow());
    rows.addEventListener('click', (event) => {
        if (event.target.closest('.remove-row')) {
            event.target.closest('.early-row').remove();
            rows.querySelectorAll('.early-row').forEach((row, index) => {
                row.querySelectorAll('[data-name], input[name]').forEach((input) => {
                    const field = input.dataset.name ?? input.name.match(/\[(date|amount)\]$/)?.[1];
                    if (field) input.name = `early_repayments[${index}][${field}]`;
                });
            });
        }
    });
})();
</script>
</body>
</html>
