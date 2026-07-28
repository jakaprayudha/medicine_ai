//=========================================
// AI CLINICAL COPILOT
//=========================================

const chatBody = document.getElementById("chatBody");

const chatInput = document.getElementById("chatInput");

const sendChat = document.getElementById("sendChat");
function addUserMessage(text) {
  chatBody.insertAdjacentHTML(
    "beforeend",
    `

        <div class="user-message">

            ${text}

        </div>

    `,
  );

  chatBody.scrollTop = chatBody.scrollHeight;
}

function addBotMessage(text) {
  chatBody.insertAdjacentHTML(
    "beforeend",
    `

        <div class="bot-message">

            ${text}

        </div>

    `,
  );

  chatBody.scrollTop = chatBody.scrollHeight;
}
function showLoading() {
  chatBody.insertAdjacentHTML(
    "beforeend",
    `

        <div
            class="bot-message"
            id="loadingBot">

            🤖 Sedang berpikir...

        </div>

    `,
  );

  chatBody.scrollTop = chatBody.scrollHeight;
}

function hideLoading() {
  const el = document.getElementById("loadingBot");

  if (el) el.remove();
}
const CHAT_SYSTEM_PROMPT = `

Anda adalah AI Clinical Copilot.

Jawab hanya pertanyaan medis.

Fokus pada:

- ICD-10

- ICD-9-CM

- Clinical Guideline

- SOAP

- Diagnosis

- Differential Diagnosis

- Drug Interaction

- Dosis Obat

- Interpretasi Laboratorium

- Evidence Based Medicine

Jawaban menggunakan Bahasa Indonesia.

`;
async function askAI(question) {
  showLoading();

  try {
    const response = await fetch(
      "https://openrouter.ai/api/v1/chat/completions",

      {
        method: "POST",

        headers: {
          Authorization: `Bearer ${window.APP_CONFIG.OPENROUTER_KEY}`,
          "Content-Type": "application/json",
        },

        body: JSON.stringify({
          model: "openai/gpt-4.1",

          messages: [
            {
              role: "system",

              content: CHAT_SYSTEM_PROMPT,
            },

            {
              role: "user",

              content: question,
            },
          ],

          temperature: 0.3,

          max_tokens: 300,
        }),
      },
    );

    const json = await response.json();
    console.log(json);

    hideLoading();

    addBotMessage(json.choices[0].message.content);
  } catch (e) {
    hideLoading();

    addBotMessage("❌ Gagal menghubungi AI.");
  }
}
sendChat.onclick = () => {
  const q = chatInput.value.trim();

  if (q === "") return;

  addUserMessage(q);

  chatInput.value = "";

  askAI(q);
};
chatInput.addEventListener(
  "keypress",

  function (e) {
    if (e.key === "Enter") {
      sendChat.click();
    }
  },
);
