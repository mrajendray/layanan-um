using System;
using System.Net;
using Microsoft.Win32;
using System.Runtime.InteropServices;
using System.IO;

namespace layanan_um_login
{
    class Program
    {
        private static string port;
        private static string username;
        private static string password;

        static void Main(string[] args)
        {
            // prepare login file
            var MyIni = new IniFile(@"C:\UM\Evan\config.ini");

            port = MyIni.Read("port", "app");
            username = MyIni.Read("username", "login");
            password = MyIni.Read("password", "login");

            string host = "http://localhost:" + port + "/um/evan/login/";
            WebServer ws = new WebServer(SendResponse, host);
            ws.Run();
            Console.WriteLine("Login system for EVAN UM is actived");
            Console.WriteLine("Listening on: " + host);
            Console.ReadKey();
            ws.Stop();
        }
        public static string SendResponse(HttpListenerRequest request)
        {
            return "{\"username\":\"" + username + "\", \"password\":\"" + password + "\"}";
        }


        private static void SetStartup()
        {
            RegistryKey rk = Registry.CurrentUser.OpenSubKey
                ("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            rk.SetValue("EVANUM", System.Reflection.Assembly.GetExecutingAssembly().Location);
        }
    }
}
