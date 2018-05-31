using System;
using System.Net;
using System.ServiceProcess;

namespace evan_um_login
{
    public partial class Service1 : ServiceBase
    {
        private static string port;
        private static string username;
        private static string password;
        private static WebServer ws;

        public Service1()
        {
            InitializeComponent();
        }

        protected override void OnStart(string[] args)
        {
            // prepare login file
            var MyIni = new IniFile(@"C:\UM\Evan\config.ini");

            port = MyIni.Read("port", "app");
            username = MyIni.Read("username", "login");
            password = MyIni.Read("password", "login");

            string host = "http://localhost:" + port + "/um/evan/login/";
            ws = new WebServer(SendResponse, host);
            ws.Run();
            Console.WriteLine("Login system for EVAN UM is actived");
            Console.WriteLine("Listening on: " + host);
        }
        public static string SendResponse(HttpListenerRequest request)
        {
            return "{\"username\":\"" + username + "\", \"password\":\"" + password + "\"}";
        }

        protected override void OnStop()
        {
            ws.Stop();
        }
    }
}
