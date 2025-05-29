<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAE Dubai Labour Report</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 20px; padding: 20px;">

    <button onclick="window.print()" style="margin-bottom: 10px; padding: 8px 12px; font-size: 16px; cursor: pointer; background: #007BFF; color: white; border: none; border-radius: 5px;">Print</button>

    <div style="width: 100%; max-width: 1000px; margin: auto; border: 1px solid #000; padding: 15px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">UAE DUBAI LABOUR REPORT</h2>
            <img src="{{asset('public/admin/assets/img/logo.png')}}" alt="QuickServe Relocations" style="height: 100px;">
        </div>
        
        <p style="margin-top: 10px;">Jobs Type:</p>
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div style="display: flex; flex-wrap: wrap; max-width: 50%;">
                <div style="display: flex; flex-direction: column; margin-right: 25px; gap: 5px;">
                    <label>Import move - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 12px;"></label>
                    <label>Export move - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 12px;"></label>
                    <label>Local move - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 20px;"></label>
                    <label>Office Move - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 17px;"></label>
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label>Cleaning - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 12px;"></label>
                    <label>Crating - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 23px;"></label>
                    <label>Storage - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 20px;"></label>
                    <label>Redelivery - <input type="checkbox" style="width: 21px; height: 18px; border: 1px solid #000;margin-left: 0px;"></label>
                </div>
            </div>
            <div style="max-width: 50%;">
                <p style="margin: 5px 0;">Job Date: <span style="border-bottom: 1px solid black;width: 95px;display: inline-block;"></span></p>
                <p style="margin: 5px 0;">Surveyed Volume: <span style="border-bottom: 1px solid black;width: 95px;display: inline-block;"></span></p>
                <p style="margin: 5px 0;">Actual Volume: <span style="border-bottom: 1px solid black;width: 95px;display: inline-block;"></span></p>
                <p style="margin: 5px 0;">Warehouse: <span style="border-bottom: 1px solid black;width: 95px;display: inline-block;"></span></p>
                <p style="margin: 5px 0;">Customer's Name: <span style="border-bottom: 1px solid black;width: 95px;display: inline-block;"></span></p>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 120px;">
                <p style="margin-left: -264%;">JOB NO.: _______</p>
                <p style="">QSR NO.: _______</p>
            </div>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Date</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Worker’s Name</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Worker’s status FT / PT</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Start time</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Finish time</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Total hours</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Overtime hours</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Total Cost</th>
            </tr>
            <tr><td colspan="8" style="border: 1px solid black; padding: 8px;"></td></tr>
            <tr><td colspan="8" style="border: 1px solid black; padding: 8px;"></td></tr>
        </table>
        
        <p style="margin-top: 10px;"><strong>Total:</strong></p>
        
        <div style="margin-top: 20px;">
            <p>Move Manager: ____________ &nbsp; Crew Leader: ____________ &nbsp; Surveyor: ____________ &nbsp; Accountant: ____________</p>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="border: 1px solid black; padding: 8px; width: 33%;">In House Truck No. / Trips</td>
                    <td style="border: 1px solid black; padding: 8px; width: 33%;">Overtime cost</td>
                    <td style="border: 1px solid black; padding: 8px; width: 33%;">Total Cost</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">Outside Truck No. of Trips</td>
                    <td style="border: 1px solid black; padding: 8px;">Packing Material</td>
                    <td style="border: 1px solid black; padding: 8px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">Lead Fee</td>
                    <td style="border: 1px solid black; padding: 8px;">Scaffolding</td>
                    <td style="border: 1px solid black; padding: 8px;">VAT (5%)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">Taxi Cost</td>
                    <td style="border: 1px solid black; padding: 8px;">Forklift</td>
                    <td style="border: 1px solid black; padding: 8px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">Gate Pass Fee</td>
                    <td style="border: 1px solid black; padding: 8px;">Origin shipping charges</td>
                    <td style="border: 1px solid black; padding: 8px;">Total Sell</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
