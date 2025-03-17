<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('loader.css') }}" /> --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
          /* Import Google font - Poppins */
          @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
      
          * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
          }
      
          body {
            background: #E3F2FD;
          }
      
          .chatbot-toggler {
            position: fixed;
            bottom: 30px;
            right: 35px;
            outline: none;
            border: none;
            height: 50px;
            width: 50px;
            display: flex;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgb(255, 145, 0);
            transition: all 0.2s ease;
            z-index: 21474836;
          }
      
          .show-chatbot .chatbot-toggler {
            transform: rotate(90deg);
          }
      
          .chatbot-toggler span {
            color: #fff;
            position: absolute;
          }
      
          .chatbot-toggler span:last-child,
          .show-chatbot .chatbot-toggler span:first-child {
            opacity: 0;
          }
      
          .show-chatbot .chatbot-toggler span:last-child {
            opacity: 1;
          }
      
          .chatbot {
            position: fixed;
            right: 89px;
            bottom: 85px;
            width: 430px;
            height: 500px;
            z-index: 50;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
            transform: scale(0.5);
            transform-origin: bottom right;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
              0 32px 64px -48px rgba(0, 0, 0, 0.5);
            transition: all 0.1s ease;
          }
      
          .show-chatbot .chatbot {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
          }
      
          .chatbot header {
            padding: 16px 0;
            position: relative;
            text-align: center;
            color: #fff;
            background: #724ae8;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }
      
          .chatbot header span {
            position: absolute;
            right: 15px;
            top: 50%;
            display: none;
            cursor: pointer;
            transform: translateY(-50%);
          }
      
          header h2 {
            font-size: 1.4rem;
          }
      
          .chatbot .chatbox {
            overflow-y: auto;
            height: 510px;
            padding: 30px 20px 100px;
          }
      
          .chatbot :where(.chatbox, textarea)::-webkit-scrollbar {
            width: 6px;
          }
      
          .chatbot :where(.chatbox, textarea)::-webkit-scrollbar-track {
            background: #fff;
            border-radius: 25px;
          }
      
          .chatbot :where(.chatbox, textarea)::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 25px;
          }
      
          .chatbox .chat {
            display: flex;
            list-style: none;
          }
      
          .chatbox .outgoing {
            margin: 20px 0;
            justify-content: flex-end;
          }
      
          .chatbox .incoming span {
            width: 32px;
            height: 32px;
            color: #fff;
            cursor: default;
            text-align: center;
            line-height: 32px;
            align-self: flex-end;
            background: #724ae8;
            border-radius: 4px;
            margin: 0 10px 7px 0;
          }
      
          .chatbox .chat p {
            white-space: pre-wrap;
            padding: 12px 16px;
            border-radius: 10px 10px 0 10px;
            max-width: 75%;
            color: #fff;
            font-size: 0.95rem;
            background: #724ae8;
          }
      
          .chatbox .incoming p {
            border-radius: 10px 10px 10px 0;
          }
      
          .chatbox .chat p.error {
            color: #721c24;
            background: #f8d7da;
          }
      
          .chatbox .incoming p {
            color: #000;
            background: #f2f2f2;
          }
      
          .chatbot .chat-input {
            display: flex;
            gap: 5px;
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #fff;
            padding: 3px 20px;
            border-top: 1px solid #ddd;
          }
      
          .chat-input textarea {
            height: 55px;
            width: 100%;
            border: none;
            outline: none;
            resize: none;
            max-height: 180px;
            padding: 15px 15px 15px 0;
            font-size: 0.95rem;
          }
      
          .chat-input span {
            align-self: flex-end;
            color: #724ae8;
            cursor: pointer;
            height: 55px;
            display: flex;
            align-items: center;
            visibility: hidden;
            font-size: 1.35rem;
          }
      
          .chat-input textarea:valid~span {
            visibility: visible;
          }
      
          @media (max-width: 490px) {
            .chatbot-toggler {
              right: 20px;
              bottom: 20px;
            }
      
            .chatbot {
              right: 0;
              bottom: 0;
              height: 100%;
              border-radius: 0;
              width: 100%;
            }
      
            .chatbot .chatbox {
              height: 90%;
              padding: 25px 15px 100px;
            }
      
            .chatbot .chat-input {
              padding: 5px 15px;
            }
      
            .chatbot header span {
              display: block;
            }
          }
        </style>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js','resources/css/app.css', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        
    </head>
    <body class="font-sans antialiased">
        @inertia

     <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <div>
      <button class="chatbot-toggler">
        <span class="material-symbols-rounded"><img src="{{ asset('images/ai.png') }}" alt="Ảnh mô tả"></span>
        <span class="material-symbols-outlined">close</span>
      </button>
      <div class="chatbot">
        <header>
          <h2> Trợ lý thông minh</h2>
          <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
          <li class="chat incoming">
            <span><img style="width: 25px; height: 25px;" src="{{ asset('images/ai.png') }}" alt="Ảnh mô tả"></span>
            <p>Xin chào 👋<br>Tôi có thể giúp gì cho bạn?</p>
          </li>
        </ul>
        <div class="chat-input">
          <textarea placeholder="Nhập câu hỏi của bạn..." spellcheck="false" required></textarea>
          <span id="send-btn" class="material-symbols-rounded">send</span>
        </div>
      </div>
    </div>

    
        
        
    </body>
    {{-- <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "166806116515585");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v18.0'
        });
      };

      (function(d, s, id) {
        let headers = new Headers();
        headers.append('Access-Control-Allow-Origin', 'https://topfood.com');
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> --}}

    <script>
      const chatbotToggler = document.querySelector(".chatbot-toggler");
      const closeBtn = document.querySelector(".close-btn");
      const chatbox = document.querySelector(".chatbox");
      const chatInput = document.querySelector(".chat-input textarea");
      const sendChatBtn = document.querySelector(".chat-input span");
    
      let userMessage = null; // Variable to store user's message
      const API_KEY = "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"; // Replace with your OpenAI GPT API key
      const inputInitHeight = chatInput.scrollHeight;
    
      const createChatLi = (message, className) => {
        // Create a chat <li> element with passed message and className
        const chatLi = document.createElement("li");
        chatLi.classList.add("chat", `${className}`);
        let chatContent = className === "outgoing" ? `<p></p>` : ` <span><img style="width: 25px; height: 25px;" src="{{ asset('images/ai.png') }}" alt="Ảnh mô tả"></span><p></p>`;
        chatLi.innerHTML = chatContent;
        chatLi.querySelector("p").textContent = message;
        return chatLi; // return chat <li> element
      }
    
      const generateResponse = async (chatElement) => {
        const API_URL = "https://api.openai.com/v1/chat/completions"; // Update the API URL
        const messageElement = chatElement.querySelector("p");
    
        // Define the properties and message for the API request
        const requestOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${API_KEY}`
          },
          body: JSON.stringify({
            model: "gpt-3.5-turbo",
            messages: [
              {
                role: "system",
                content: "Tôi có thể giúp gì cho bạn."
              },
              {
                role: "user",
                content: userMessage
              }
            ],
            max_tokens: 100,
          })
        }
    
        try {
          const data = await (await fetch(API_URL, requestOptions)).json();
          messageElement.textContent = data.choices[0].message.content.trim();
        } catch (error) {
          messageElement.classList.add("error");
          messageElement.textContent = "Oops! Something went wrong. Please try again.";
        } finally {
          chatbox.scrollTo(0, chatbox.scrollHeight);
        }
      }
    
      const handleChat = () => {
        userMessage = chatInput.value.trim(); // Get user entered message and remove extra whitespace
        if (!userMessage) return;
    
        // Clear the input textarea and set its height to default
        chatInput.value = "";
        chatInput.style.height = `${inputInitHeight}px`;
    
        // Append the user's message to the chatbox
        chatbox.appendChild(createChatLi(userMessage, "outgoing"));
        chatbox.scrollTo(0, chatbox.scrollHeight);
    
        setTimeout(() => {
          // Display "Thinking..." message while waiting for the response
          const incomingChatLi = createChatLi("Đang suy nghĩ...", "incoming");
          chatbox.appendChild(incomingChatLi);
          chatbox.scrollTo(0, chatbox.scrollHeight);
          generateResponse(incomingChatLi);
        }, 600);
      }
    
      chatInput.addEventListener("input", () => {
        // Adjust the height of the input textarea based on its content
        chatInput.style.height = `${inputInitHeight}px`;
        chatInput.style.height = `${chatInput.scrollHeight}px`;
      });
    
      chatInput.addEventListener("keydown", (e) => {
        // If Enter key is pressed without Shift key and the window 
        // width is greater than 800px, handle the chat
        if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
          e.preventDefault();
          handleChat();
        }
      });
    
      sendChatBtn.addEventListener("click", handleChat);
      closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
      chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
    </script>
</html>
