import type { MessageReceived } from "wa-multi-session";
import { CreateWebhookProps, webhookClient } from ".";
import {
  handleWebhookAudioMessage,
  handleWebhookDocumentMessage,
  handleWebhookImageMessage,
  handleWebhookVideoMessage,
} from "./media";

type WebhookMessageBody = {
  session: string;
  from: string | null;
  message: string | null;

  media: {
    image: string | null;
    video: string | null;
    document: string | null;
    audio: string | null;
  };
};

export const createWebhookMessage =
  (props: CreateWebhookProps) => async (message: MessageReceived) => {
    if (message.key.fromMe || message.key.remoteJid?.includes("broadcast"))
      return;

    const endpoint = `${props.baseUrl}/message`;

    const image = await handleWebhookImageMessage(message);
    const video = await handleWebhookVideoMessage(message);
    const document = await handleWebhookDocumentMessage(message);
    const audio = await handleWebhookAudioMessage(message);
const from: string =
  [
    message.key.remoteJidAlt,
    message.key.remoteJid,
  ]
    .filter((jid): jid is string => typeof jid === "string")
    .map(jid => jid.replace(/@.+$/, ""))
    .find(num => num.startsWith("62")) ?? "";
    const body = {
      session: message.sessionId,
      from: from,
      message:
        message.message?.conversation ||
        message.message?.extendedTextMessage?.text ||
        message.message?.imageMessage?.caption ||
        message.message?.videoMessage?.caption ||
        message.message?.documentMessage?.caption ||
        message.message?.contactMessage?.displayName ||
        message.message?.locationMessage?.comment ||
        message.message?.liveLocationMessage?.caption ||
        null,

      /**
       * media message
       */
      media: {
        image,
        video,
        document,
        audio,
      },
    } satisfies WebhookMessageBody;
    webhookClient.post(endpoint, body).catch(console.error);
  };
