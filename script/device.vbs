Set WshShell = CreateObject("WScript.Shell") 
WshShell.Run chr(34) & "device.cmd" & Chr(34), 0
Set WshShell = Nothing
