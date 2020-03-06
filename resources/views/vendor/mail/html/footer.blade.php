<tr>
    <td style="background: #002f58;">
        <table class="footer" align="center" width="100%" cellpadding="0" cellspacing="0"
               style="text-align: center;color: #fff;font-size: 14px;background: #002f58">
            <tr>
                <td class="content-cell" align="center" style="padding:10px !important;">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
