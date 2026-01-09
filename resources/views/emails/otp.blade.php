<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 30px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600; letter-spacing: -0.5px;">
                                Verify Your Account
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 40px 30px;">
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 30px; color: #374151; font-size: 16px; line-height: 1.6;">
                                We received a request to reset your password. Please use the following One-Time Password (OTP) to complete your verification:
                            </p>

                            <!-- OTP Box -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 0 0 30px;">
                                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 30px; display: inline-block;">
                                            <div style="background-color: rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 20px 30px; backdrop-filter: blur(10px);">
                                                <p style="margin: 0 0 10px; color: #ffffff; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9;">
                                                    Your OTP Code
                                                </p>
                                                <p style="margin: 0; color: #ffffff; font-size: 36px; font-weight: 700; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                                                    {{ $otp }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Instructions -->
                            <div style="background-color: #f9fafb; border-left: 4px solid #667eea; border-radius: 6px; padding: 20px; margin: 0 0 30px;">
                                <p style="margin: 0 0 12px; color: #1f2937; font-size: 15px; font-weight: 600;">
                                    ⚠️ Important:
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #4b5563; font-size: 14px; line-height: 1.8;">
                                    <li>This code will expire in 5 minutes</li>
                                    <li>Never share this code with anyone</li>
                                    <li>If you didn't request this code, please ignore this email</li>
                                </ul>
                            </div>

                            <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you have any questions or concerns, please don't hesitate to contact our support team.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9fafb; border-radius: 0 0 12px 12px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px; text-align: center; line-height: 1.6;">
                                This is an automated message, please do not reply to this email.
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px; text-align: center;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

